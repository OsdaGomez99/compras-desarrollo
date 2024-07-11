<?php

namespace App\Http\Livewire\Compras\Ofertas;
use App\Models\Compras\Oferta;
use App\Models\Compras\DetalleOferta;
use App\Models\Compras\Cotizacion;
use App\Models\Compras\DetalleCotizacion;
use Carbon\Carbon;
use Livewire\WithPagination;

use Livewire\Component;

class OfertasComponent extends Component
{
    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_descripcion, $detalle_oferta;


    public $listeners = [
        'oferta:busqueda' => 'busqueda',
        'oferta:deleteData' => 'deleteData',
        'oferta:enviarData' => 'enviarData',
        'oferta:aceptarData' => 'aceptarData',
        'oferta:recibidaData' => 'recibidaData'
    ];


    public function render()
    {
        if ($this->busqueda) {
            $of = Oferta::with('cotizacion.detalles_cot.detalle_req.requisicion.linea', 'proveedor')
                            ->search($this->busqueda)
                            ->orderBy('id_cotizacion', 'DESC')
                            ->paginate(10);

            $ofertas = $of->setCollection($of->groupBy('id_cotizacion'));
        }
        else
        {
            $of = Oferta::with('cotizacion.detalles_cot.detalle_req.requisicion.linea', 'proveedor')
                            ->orderBy('id_cotizacion', 'DESC')
                            ->paginate(10);

            $ofertas = $of->setCollection($of->groupBy('id_cotizacion'));

        }

        return view('livewire.compras.ofertas.ofertas-component', compact('ofertas'));
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function enviarConfirm(Oferta $of)
    {
        if ($of->estatus == 'TRANSCRITA')
        {
                $this->dispatchBrowserEvent('enviarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres enviar la cotización al proveedor(a) <strong>' . $of->proveedor->nombre . ' de la cotización <strong>' . $of->cotizacion->numero . '</strong>',
                    'id' => $of->id,
                    'modulo' => 'oferta'
                ]);
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

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Enviada!',
            'message' => 'La cotización <strong>' . $cotizacion->numero . '</strong> ha sido enviada con éxito.'
        ]);

        $this->emitSelf('actualizar');

    }

    //Marcar como recibida la oferta
    public function recibidaConfirm(Oferta $of)
    {
        if ($of->estatus == 'COTIZACION ENVIADA')
        {
                $this->dispatchBrowserEvent('recibidaConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres marcar como recibida la oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> de la cotización <strong>' . $of->cotizacion->numero . '</strong>',
                    'id' => $of->id,
                    'modulo' => 'oferta'
                ]);
        }
        else
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> no se puede marcar como recibida porque su estatus es <strong>' . $of->estatus . '</strong>'
            ]);
        }
    }

    public function recibidaData($id)
    {
        $oferta = Oferta::findOrFail($id);
        $oferta->estatus = 'OFERTAS RECIBIDAS';
        $oferta->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Recibida!',
            'message' => 'Se han recibido ofertas del proveedor <strong>' . $oferta->proveedor->nombre . '</strong> para la cotización <strong>' . $oferta->cotizacion->numero . '</strong>'
        ]);
    }

    //Aceptar la oferta del proveedor
    public function aceptarConfirm(Oferta $of)
    {
        if ($of->estatus == 'OFERTAS RECIBIDAS')
        {
                $this->dispatchBrowserEvent('aceptarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres aceptar la oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> de la cotización <strong>' . $of->cotizacion->numero . '</strong>',
                    'id' => $of->id,
                    'modulo' => 'oferta'
                ]);
        }
        else
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> no se puede aprobar porque su estatus es <strong>' . $of->estatus . '</strong>'
            ]);
        }
    }

    public function aceptarData($id)
    {
        $oferta = Oferta::findOrFail($id);
        $oferta->estatus = 'ACEPTADA';
        $oferta->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Aceptada!',
            'message' => 'La oferta <strong>' . $oferta->numero . '</strong> ha sido aceptada con éxito.'
        ]);
    }

    public function deleteConfirm(Oferta $of)
    {
        if ($of->estatus == 'TRANSCRITA')
        {
                $this->dispatchBrowserEvent('deleteConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres eliminar la oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> de la cotización <strong>' . $of->cotizacion->numero . '</strong>',
                    'id' => $of->id,
                    'modulo' => 'oferta'
                ]);
        }
        else
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La oferta del proveedor(a) <strong>' . $of->proveedor->nombre . '</strong> no se puede eliminar porque su estatus es <strong>' . $of->estatus . '</strong>'
            ]);
        }
    }

    public function deleteData($id)
    {
        $oferta = Oferta::findOrFail($id);
        $oferta->delete();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Eliminada!',
            'message' => 'La oferta ha sido eliminada con éxito.'
        ]);

        $this->emit('actualizar');
    }


}
