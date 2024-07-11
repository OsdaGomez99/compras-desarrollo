<?php

namespace App\Http\Livewire\Compras\Requisiciones;
use App\Models\Compras\Requisicion;
use App\Models\Compras\DetalleRequisicion;
use App\Models\Compras\DetalleCotizacion;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use Livewire\Component;

class RequisicionesComponent extends Component
{
    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_descripcion, $detalle_requisicion;

    protected $listeners = [
        'req:busqueda' => 'busqueda',
        'req:aprobarData' => 'aprobarData',
        'req:anularData' => 'anularData',
        'req:reversarData' => 'reversarData',
        'req:deleteData' => 'deleteData',
        'req:actualizar' => '$refresh'
    ];


    public function render()
    {
        /* if (Auth::user()->hasRole('BIENES'))
        {
            if ($this->busqueda) {
                $requisiciones = Requisicion::with('unidad', 'linea', 'prioridad')
                                            ->where('estatus', '!=', 'ELIMINADA')
                                            ->where('tipo', 'BIENES')
                                            ->search($this->busqueda)
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);
            } else {
                $requisiciones = Requisicion::with('unidad', 'linea', 'prioridad')
                                            ->where('estatus', '!=', 'ELIMINADA')
                                            ->where('tipo', 'BIENES')
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);
            }
        }
        else
        {
            if ($this->busqueda) {
                $requisiciones = Requisicion::with('unidad', 'linea', 'prioridad')
                                            ->where('estatus', '!=', 'ELIMINADA')
                                            ->where('tipo', 'SERVICIOS')
                                            ->search($this->busqueda)
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);
            } else {
                $requisiciones = Requisicion::with('unidad', 'linea', 'prioridad')
                                            ->where('estatus', '!=', 'ELIMINADA')
                                            ->where('tipo', 'SERVICIOS')
                                            ->orderBy('id', 'desc')
                                            ->paginate(10);
            }
        } */

        if ($this->busqueda) {
            $requisiciones = Requisicion::with('unidad', 'linea', 'prioridad')
                                        ->where('estatus', '!=', 'ELIMINADA')
                                        ->search($this->busqueda)
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);
        } else {
            $requisiciones = Requisicion::with('unidad', 'linea', 'prioridad')
                                        ->where('estatus', '!=', 'ELIMINADA')
                                        ->orderBy('id', 'desc')
                                        ->paginate(10);
        }

        return view('livewire.compras.requisiciones.requisiciones-component', compact('requisiciones'));
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function detalleRequisicion($id)
    {
        $requisicion = Requisicion::with('unidad', 'linea', 'prioridad', 'anno')->findOrFail($id);
        $fecha_requisicion = \Carbon\Carbon::parse($requisicion->fecha_requisicion)->format('d/m/Y');
        $unidad = $requisicion->unidad->nombre;
        $linea = $requisicion->linea->descripcion;
        $prioridad = $requisicion->prioridad->descripcion;
        $anno = $requisicion->anno->anno;


        if ($this->detalle_descripcion != $requisicion->id) {

            $this->fill([
                'detalle_descripcion' => $requisicion->id,
                'detalle_requisicion' => [
                    "Nro. Requisición: $requisicion->numero",
                    "Tipo de Requisición: $requisicion->tipo",
                    "Fecha de Requisición: $fecha_requisicion",
                    "Fecha de Recepción: $requisicion->fecha_recepcion",
                    "Año Presupuesto: $anno",
                    "Trimestre: $requisicion->trimestre",
                    "Unidad Solicitante: $unidad",
                    "Nro. Referencia: $requisicion->num_referencia",
                    "Línea: $linea",
                    "Nota: $requisicion->justificacion",
                    "Status: $requisicion->estatus",
                    "Prioridad: $prioridad"
                ],
            ]);

        } else {
            $this->fill([
                'detalle_descripcion' => '',
                'detalle_requisicion' => ''
            ]);
        }

    }

    public function aprobarConfirm(Requisicion $req)
    {
        $detalles = DetalleRequisicion::where('id_requisicion', '=', $req->id)
                                    ->get();

        if ($req->estatus == 'TRANSCRITA')
        {
            if($detalles->count() < 1)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'La requisición <strong>' . $req->numero . '</strong> no se puede aprobar porque no tiene detalles agregados</strong>'
                ]);
            }
            else
            {
                $this->dispatchBrowserEvent('aprobarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres aprobar la requisición <strong>' . $req->numero,
                    'id' => $req->id,
                    'modulo' => 'req'
                ]);
            }


        } else {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La requisición <strong>' . $req->numero . '</strong> no se puede aprobar porque su estatus es <strong>' . $req->estatus . '</strong>'
            ]);
        }
    }

    public function aprobarData($id)
    {
        $requisicion = Requisicion::findOrFail($id);
        $requisicion->estatus = 'APROBADA';
        $requisicion->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Aprobado!',
            'message' => 'La requisición <strong>' . $requisicion->numero . '</strong> ha sido aprobada con éxito.'
        ]);
    }

    //Funcion de Anular Requisicion
    public function anularConfirm(Requisicion $req)
    {
        $requisicion = Requisicion::with('detalle_req.detalles_cot')->where('id', '=', $req->id)->first();

        $r = $requisicion->detalle_req->map( function ($value, $key) {
            return $value->id;
        } )->toArray();

        foreach ($r as $item)
        {
            $cot = DetalleCotizacion::where('id_detalle_requisicion', '=', $item)->get();
            if ($cot->count() > 0)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'No se puede anular',
                    'message' => 'La requisición <strong>' . $req->numero . '</strong> no se puede anular porque esta en uso',
                ]);
            }
            else
            {
                $this->dispatchBrowserEvent('anularConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres anular la requisición <strong>' . $req->numero,
                    'id' => $req->id,
                    'modulo' => 'req'
                ]);
                break;
            }
        }
    }

    public function anularData($id)
    {
        $requisicion = Requisicion::findOrFail($id);
        $requisicion->estatus = 'ANULADA';
        $requisicion->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Anulada!',
            'message' => 'La requisición <strong>' . $requisicion->numero . '</strong> ha sido anulada con éxito.'
        ]);
    }


    //Funcion de Reversar Requisicion
    public function reversarConfirm(Requisicion $req)
    {
        $requisicion = Requisicion::with('detalle_req.detalles_cot')->where('id', '=', $req->id)->first();

        $r = $requisicion->detalle_req->map( function ($value, $key) {
            return $value->id;
        } )->toArray();

        foreach ($r as $item)
        {
            $cot = DetalleCotizacion::with('cotizacion')->where('id_detalle_requisicion', '=', $item)->get();
            if ($cot->count() > 0)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'No se puede reversar!',
                    'message' => 'La requisición <strong>' . $req->numero .
                    '</strong> no se puede reversar porque está en uso por la cotización <strong>' . $cot[0]->cotizacion->numero .'</strong>',
                ]);
            }
            else
            {
                $this->dispatchBrowserEvent('reversarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres reversar la requisición <strong>' . $req->numero,
                    'id' => $req->id,
                    'modulo' => 'req'
                ]);
                break;
            }
        }
    }

    public function reversarData($id)
    {
        $requisicion = Requisicion::findOrFail($id);
        $requisicion->estatus = 'TRANSCRITA';
        $requisicion->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Reversada!',
            'message' => 'La requisición <strong>' . $requisicion->numero . '</strong> ha sido reversada con éxito. Puede volver a modificar esta requisición'
        ]);
    }


    //Funcion de Eliminar Requisicion
    public function deleteConfirm(Requisicion $req)
    {
        if ($req->estatus == 'TRANSCRITA')
        {
            $this->dispatchBrowserEvent('deleteConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar la requisición <strong>' . $req->numero,
                'id' => $req->id,
                'modulo' => 'req'
            ]);
        }
        else
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'No se puede eliminar',
                'message' => 'La requisición <strong>' . $req->numero . '</strong> no se puede eliminar porque ya fue procesada',
            ]);
        }

    }

    public function deleteData($id)
    {
        $req = Requisicion::findOrFail($id);
        $req->estatus = 'ELIMINADA';
        $req->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Eliminada!',
            'message' => 'La requisición <strong>' . $req->numero . '</strong> ha sido eliminada con éxito.'
        ]);
    }



}
