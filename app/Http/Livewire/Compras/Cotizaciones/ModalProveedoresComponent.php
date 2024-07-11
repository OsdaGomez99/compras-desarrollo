<?php

namespace App\Http\Livewire\Compras\Cotizaciones;

use Livewire\Component;
use App\Models\Compras\Cotizacion;
use App\Models\Compras\DetalleCotizacion;
use App\Models\Compras\Oferta;
use App\Models\Compras\DetalleOferta;
use App\Models\Compras\Proveedor;
use Carbon\Carbon;

class ModalProveedoresComponent extends Component
{
    public $modal = false;
    public $cotizacion, $id_cotizacion,$id_proveedor, $tipo;
    public $proveedores, $detalles;
    public $ofertas, $existe;

    protected $listeners = [
        'proveedor:deleteData' => 'deleteData',
        'proveedor:enviarData' => 'enviarData',
        'proveedor:enviarDataTodos' => 'enviarDataTodos',
        'actualizar' => '$refresh',
        'imprimir' => 'imprimir',
        'abrir' => 'abrirModal',
    ];


    protected $rules = [
        'id_proveedor' => 'required',
    ];

    public function render()
    {
        $this->fill([
            'proveedores' => Proveedor::all(['id', 'nombre'])->sortBy('nombre'),
        ]);

        return view('livewire.compras.cotizaciones.modal-proveedores-component');
    }

    public function abrirModal($id)
    {
        $this->cotizacion = Cotizacion::where('id', $id)->first();
        $this->id_cotizacion = $id;
        $this->tipo = $this->cotizacion->tipo;
        $this->ofertas = Oferta::with('detalles_of')->where('id_cotizacion', $id)->get();

        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function enviarConfirm(Oferta $of)
    {
        $detalles = DetalleCotizacion::where('id_cotizacion', '=', $of->cotizacion->id)->get();

        if ($of->estatus == 'TRANSCRITA')
        {
            if($detalles->count() < 1)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'No se pueden enviar ofertas al proveedor <strong>' . $of->proveedor->nombre . '</strong> porque no existen detalles agregados</strong>'
                ]);
            }
            else
            {
                $this->dispatchBrowserEvent('enviarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres enviar la cotización al proveedor(a) <strong>' . $of->proveedor->nombre . ' de la cotización <strong>' . $of->cotizacion->numero . '</strong>',
                    'id' => $of->id,
                    'modulo' => 'proveedor'
                ]);
            }
        }
        else
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> no se puede enviar porque su estatus es <strong>' . $of->estatus . '</strong>'
            ]);
        }
    }

    //Enviar cotizacion a un proveedor
    public function enviarData($id)
    {
        $oferta = Oferta::findOrFail($id);
        $detalles =  DetalleCotizacion::where('id_cotizacion', $oferta->cotizacion->id)->get();
        for ($i=0; $i < count($detalles); $i++) {
            DetalleOferta::create
            ([
                'id_oferta' => $oferta->id,
                'id_detalle_requisicion' => $detalles[$i]->id_detalle_requisicion,
                'cantidad_cotizada' => $detalles[$i]->cantidad,
            ]);
        }
        $oferta->estatus = 'COTIZACION ENVIADA';
        $oferta->save();

        $cotizacion = Cotizacion::findOrFail($oferta->cotizacion->id);
        $oferta->fecha_entrega = Carbon::now();
        $cotizacion->estatus = 'COTIZACION ENVIADA';
        $cotizacion->save();

        $this->emit('cot:actualizar');

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Enviada!',
            'message' => 'La cotización <strong>' . $cotizacion->numero . '</strong> ha sido enviada con éxito.'
        ]);

        $this->emitSelf('actualizar');

    }

    //Enviar cotizacion a todos los proveedorescon listodos
    public function enviarDataTodos()
    {

        $oferta = Oferta::where('id_cotizacion', $this->id_cotizacion)->get();
        $detalles =  DetalleCotizacion::where('id_cotizacion', $this->cotizacion->id)->get();
        for ($i=0; $i < count($oferta); $i++) {
            for ($n=0; $n < count($detalles); $n++) {
                DetalleOferta::create
                ([
                    'id_oferta' => $oferta[$i]->id,
                    'id_detalle_requisicion' => $detalles[$n]->id_detalle_requisicion,
                    'cantidad' => $detalles[$n]->cantidad,
                    'estatus' => 'COTIZACION ENVIADA'
                ]);

                $oferta[$i]->estatus = 'COTIZACION ENVIADA';
                $oferta[$i]->save();
            }
        }

        $cotizacion = Cotizacion::findOrFail($this->id_cotizacion);
        $cotizacion->estatus = 'COTIZACION ENVIADA';
        $cotizacion->save();

        $this->emit('cot:actualizar');
        $this->emit('actualizar');

    }

    //Crear una oferta para un proveedor con estatus TRANSCRITA
    public function guardar (Oferta $oferta)
    {
        $this->existe = Oferta::where('id_proveedor', $this->id_proveedor)->where('id_cotizacion', '=', $this->cotizacion->id)->get();
        if ($this->id_proveedor == null)
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'Ingrese un proveedor'
            ]);
        }
        else if ($this->existe->count() > 0)
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'El proveedor ya se encuentra agregado'
            ]);
        }
        else
        {
            //Guardar la oferta
            $oferta->id_cotizacion = $this->cotizacion->id;
            $oferta->id_proveedor = $this->id_proveedor;
            $oferta->fecha_oferta = Carbon::now();
            $oferta->tipo = $this->tipo;
            if($oferta->tipo == 'BIENES')
            {
                $oferta->condiciones_venta =
                '1. LA OFERTA DEBERA PRESENTARTE UN (1) DIA HABIL CONTADO A PARTIR DEL DIA SIGUIENTE DE HABER RECIBIDO ESTA COMUNICACION.
                2. LOS PRECIOS OFERTADOS DEBERAN MANTENERSE POR UN LAPSO DE 15 DIAS HABILES (ART. 63 Y 64 LCP).
                3. LA OFERTA DEBE SER PRESENTADA FIRMADA Y SELLADA EN SOBRE CERRADO A LA HORA Y FECHA SOLICITADA. EL ARCHIVO DIGITAL SUMINISTRADO VIA CORREO ELECTRONICO.
                4. LA OFERTA DEBE ESTAR ACOMPAÑADA DE UNA COPIA DE LA LICENCIA DE INDUSTRIA Y COMERCIO.
                5. CUMPLIR CON LO ESTABLECIDO EN EL ARTICULO 31 DE LCP (COMPROMISO DE RESPOSABILIDAD SOCIAL, 3%)
                6. LA OFERTA DEBE ESTAR ACOMPAÑADA DE LA CARTA DE COMPROMISO DE FIANZA DE FIEL CUMPLIMIENTO.
                7. DE ACUERDO A LO ESTABLECIDO EN EL ART. 59 DE LA LCP, EL PRESUPUESTO BASE PARA ESTA CONTRATACION ES: (PRESUPUESTO)
                POR FAVOR INCLUIR LOS SIGUIENTES DOCUMENTOS:
                -COPIA DEL REGISTRO NACIONAL DE CONTRATACIONES.
                -SOLVENCIA DEL IVSS.
                -SOLVENCIA LABORAL.';
            }
            else
            {
                $oferta->condiciones_venta =
                '1. OFERTAR RESPETANDO LA CANTIDAD DE RENGLONES.
                2. ESPECIFICAR LA FORMA DE PAGO, TIEMPO DE ENTREGA, VALIDEZ DE LA OFERTA (NO MENOR A 15 DIAS) Y PROPUESTA DEL CRONOGRAMA DE EJECUCION.
                3. LA RECEPCION ES HASTA LA FECHA Y HORA TOPE SEÑALADA, EN FISICO, FAX O CORREO ELECTRONICO.
                4. PARA LA SELECCION DE LAS OFERTAS DE CONSIDERARA EL ART. 13 DE LA LEY DE CONTRATACIONES PUBLICAS, REFERIDO AL VALOR AGREGADO NACIONAL.
                5. DANDO CUMPLIMIENTO AL ART. 31 DE LA LEY DE CONTRATACIONES PUBLICAS SE CONSIDERARA EL 3% DEL COMPROMISO DE RESPONSABILIDAD SOCIAL, SI LA OBRA O SERVICIO EXCEDE LAS 2500 UNIDADES TRIBUTARIAS
                6. VISITA TECNICA:
                7. DANDO CUMPLIMIENTO AL ART. 59 DE LA LAY DE CONTRATACIONES PUBLICAS, LE INFORMAMOS QUE EL PRESUPUESTO BASE QUE MANEJA LA INSTITUCION PARA ESTA CONTRATACION ES DE (PRESUPUESTO), INCLUYENDO LOS TRIBUTOS, Y CALCULADO DE ACUERDO A LAS REGULACIONES QUE RIGEN LA MATERIA DE PRECIOS JUSTOS.';
            }
            $oferta->save();

        }

        $this->ofertas = Oferta::with('detalles_of')->where('id_cotizacion', $this->cotizacion->id)->get();

        $this->emitSelf('actualizar');

    }

    public function deleteData($id)
    {
        $oferta = Oferta::findOrFail($id);
        $oferta->delete();

        $this->emit('actualizar');
    }

}
