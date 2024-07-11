<?php

namespace App\Http\Livewire\Compras\Cotizaciones;
use App\Models\Compras\Cotizacion;
use App\Models\Compras\DetalleCotizacion;
use App\Models\Compras\Oferta;
use App\Models\Compras\Requisicion;
use Livewire\WithPagination;

use Livewire\Component;

class CotizacionesComponent extends Component
{
    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_descripcion, $detalle_cotizacion;

    protected $listeners = [
        'cot:busqueda' => 'busqueda',
        'cot:deleteData' => 'deleteData',
        'cot:actualizar' => '$refresh',
    ];

    public function render()
    {
        if ($this->busqueda) {
            $cotizaciones = Cotizacion::with('requisicion')
                                    ->where('estatus', '!=', 'ELIMINADA')
                                    ->search($this->busqueda)
                                    ->orderBy('id', 'desc')
                                    ->paginate(10);
        } else {
            $cotizaciones = Cotizacion::with('requisicion')
                                    ->where('estatus', '!=', 'ELIMINADA')
                                    ->orderBy('id', 'desc')
                                    ->paginate(10);
        }
        return view('livewire.compras.cotizaciones.cotizaciones-component', compact('cotizaciones'));
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function detalleCotizacion ($id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $fecha_cotizacion = \Carbon\Carbon::parse($cotizacion->fecha_cotizacion)->format('d/m/Y');
        $fecha_vigencia = \Carbon\Carbon::parse($cotizacion->fecha_vigencia)->format('d/m/Y');
        $fecha_tope = \Carbon\Carbon::parse($cotizacion->fecha_tope)->format('d/m/Y');
        $hora_tope = \Carbon\Carbon::parse($cotizacion->hora_tope)->format('g:i A');
        $fecha_visita = \Carbon\Carbon::parse($cotizacion->fecha_visita)->format('d/m/Y');
        $hora_visita = \Carbon\Carbon::parse($cotizacion->hora_visita)->format('g:i A');

        if ($this->detalle_descripcion != $cotizacion->id) {

            if ($cotizacion->tipo == 'BIENES')
            {
                $this->fill([
                    'detalle_descripcion' => $cotizacion->id,
                    'detalle_cotizacion' => [
                        "Nro. Cotización: $cotizacion->numero",
                        "Tipo de Cotización: $cotizacion->tipo",
                        "Fecha de Cotización: $fecha_cotizacion",
                        "Fecha de Vigencia: $fecha_vigencia",
                        "Status: $cotizacion->estatus",
                    ],
                ]);
            }
            else
            {
                $this->fill([
                    'detalle_descripcion' => $cotizacion->id,
                    'detalle_cotizacion' => [
                        "Nro. Cotización: $cotizacion->numero",
                        "Tipo de Cotización: $cotizacion->tipo",
                        "Fecha de Cotización: $fecha_cotizacion",
                        "Fecha de Vigencia: $fecha_vigencia",
                        "Fecha Tope: $fecha_tope",
                        "Hora Tope: $hora_tope",
                        "Fecha Visita: $fecha_visita",
                        "Hora Visita: $hora_visita",
                        "Lugar Visita: $cotizacion->lugar_visita",
                        "Status: $cotizacion->estatus",
                    ],
                ]);
            }

        } else {
            $this->fill([
                'detalle_descripcion' => '',
                'detalle_cotizacion' => ''
            ]);
        }

    }

    /*
    public function aprobarConfirm(Cotizacion $cot)
    {
        $detalles = DetalleCotizacion::where('id_cotizacion', '=', $cot->id)
                                    ->get();
        $ofertas = Oferta::where('id_cotizacion', '=', $cot->id)
                                    ->get();

        if ($cot->estatus == 'TRANSCRITA')
        {
            if($detalles->count() < 1)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'La cotización  <strong>' . $cot->numero . '</strong> no se puede aprobar porque no tiene detalles agregados</strong>'
                ]);
            }
            else if($ofertas->count() < 1)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'La cotización  <strong>' . $cot->numero . '</strong> no se puede aprobar porque no tiene proveedores agregados</strong>'
                ]);
            }
            else
            {
                $this->dispatchBrowserEvent('aprobarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres aprobar la cotización <strong>' . $cot->numero,
                    'id' => $cot->id,
                    'modulo' => 'cot'
                ]);
            }

        } else {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La cotización <strong>' . $cot->numero . '</strong> no se puede aprobar porque su estatus es <strong>' . $cot->estatus . '</strong>'
            ]);
        }
    }

    public function aprobarData($id)
    {
        $requisicion = Cotizacion::with('detalles_cot.detalle_req')->where('id', '=', $id)->first();

        $r = array_unique($requisicion->detalles_cot->map( function ($value, $key) {
            return $value->detalle_req->id_requisicion;
        } )->toArray());

        //dd($r);

        $array = [];
        foreach($requisicion->detalle_cot as $req) {
            $array[] = $req->detalle_req->id_requisicion;
        }


        foreach($r as $value)
        {
            $req = Requisicion::findOrFail($value);
            $req->estatus = "CERRADA";
            $req->save();
        }

        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->estatus = 'OFERTAS RECIBIDAS';
        $cotizacion->save();



        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Aprobada!',
            'message' => 'La cotización <strong>' . $cotizacion->numero . '</strong> ha sido aprobada con éxito.'
        ]);
    }
    */

    public function deleteConfirm(Cotizacion $cot)
    {
        if ($cot)
        {
            $this->dispatchBrowserEvent('deleteConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar la cotización <strong>' . $cot->numero,
                'id' => $cot->id,
                'modulo' => 'cot'
            ]);
        }

    }

    public function deleteData($id)
    {
        $cot = Cotizacion::findOrFail($id);
        $cot->delete();

        $this->dispatchBrowserEvent('deleteSuccess', [
            'title' => 'Eliminado!',
            'message' => 'La cotización <strong>' . $cot->numero . '</strong> ha sido eliminada con éxito.'
        ]);
    }

}
