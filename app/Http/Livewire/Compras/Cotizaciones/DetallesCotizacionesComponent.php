<?php

namespace App\Http\Livewire\Compras\Cotizaciones;

use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Compras\DetalleCotizacion;
use App\Models\Compras\DetalleRequisicion;
use App\Models\Compras\Requisicion;
use Illuminate\Support\Facades\DB;

class DetallesCotizacionesComponent extends Component
{
    public $cotizacion, $id_proveedor;
    public $id_detalle, $num_linea, $requisicion, $tipo;
    public $requisiciones, $id_requisicion = -1;
    public $details, $detalles;

    protected $listeners = [
        'detalle:actualizar' => 'actualizar',
        'detalle:eliminar' => 'eliminar',
        'actualizar' => '$refresh',
    ];

    public function render()
    {
        $this->fill([
            'requisiciones' => Requisicion::select('id', 'numero', 'id_linea')
                                        ->with('detalle_req.detalles_cot')
                                        ->where('estatus', 'APROBADA')
                                        ->where('tipo', $this->cotizacion->tipo)
                                        ->whereNotExists(function ($query) {
                                            $query->select(DB::raw(1))
                                                ->from('compras.detalles_requisicion')
                                                ->join('compras.detalles_cotizacion', 'compras.detalles_cotizacion.id_detalle_requisicion', '=', 'compras.detalles_requisicion.id')
                                                ->whereRaw('compras.detalles_requisicion.id_requisicion = compras.requisiciones.id');
                                        })->get()
        ]);


        //Tabla de detalles registrados
        $detalles_cot = DetalleCotizacion::where('id_cotizacion', $this->cotizacion->id)
                                    ->with('cotizacion', 'detalle_req')
                                    ->get()
                                    ->groupBy('id_cotizacion');


        return view('livewire.compras.cotizaciones.detalles-cotizaciones-component', compact('detalles_cot'));
    }

    public function updatedIdRequisicion ()
    {
        if ($this->id_requisicion != -1)
        {
            $this->detalles = DetalleRequisicion::where('id_requisicion', '=', $this->id_requisicion)->get();

            $this->requisiciones = Requisicion::select('id', 'numero', 'id_linea')
                                            ->with('detalle_req.detalles_cot')
                                            ->where('estatus', 'APROBADA')
                                            ->where('tipo', $this->cotizacion->tipo)
                                            ->whereNotExists(function ($query) {
                                                $query->select(DB::raw(1))
                                                    ->from('compras.detalles_requisicion')
                                                    ->join('compras.detalles_cotizacion', 'compras.detalles_cotizacion.id_detalle_requisicion', '=', 'compras.detalles_requisicion.id')
                                                    ->whereRaw('compras.detalles_requisicion.id_requisicion = compras.requisiciones.id');
                                            })->get();
        }
    }

    public function limpiar()
    {
        $this->id_requisicion = -1;
    }

    public function actualizar($tipo, $mensaje)
    {
        $this->id_requisicion = -1;
        session()->flash($tipo, $mensaje);
    }

    public function deleteData($id)
    {
        $detalle = DetalleCotizacion::findOrFail($id);
        $detalle->delete();

        session()->flash('success', 'Detalle eliminado con éxito');
    }

    public function guardar (){

        //$this->validate();
        if ($this->id_requisicion == -1){
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'Ingrese una requisición'
            ]);
        }
        else
        {

            $detalles_cot = DetalleCotizacion::all();

            //si id_requisicion es igual a id_requisicion de algun detalle de cotizacion
            //entonces no se puede agregar
            foreach ($detalles_cot as $detalle_cot) {
                if ($detalle_cot->detalle_req->id_requisicion == $this->id_requisicion) {
                    $this->dispatchBrowserEvent('errorAlert', [
                        'title' => 'Error',
                        'message' => 'La requisición ya se encuentra agregada'
                    ]);
                    return;
                }
            }

            $this->detalles = DetalleRequisicion::where('id_requisicion', '=', $this->id_requisicion)->get();

            for ($i=0; $i < count($this->detalles); $i++) {
                DetalleCotizacion::create
                ([
                    'id_cotizacion' => $this->cotizacion->id,
                    'id_detalle_requisicion' => $this->detalles[$i]->id,
                    'cantidad' => $this->detalles[$i]->cantidad,
                ]);
            }

            $this->reset('id_requisicion');

            $this->emit('actualizar');
            //return view('compras.cotizaciones.detalle');

        }
    }

    public function eliminar ($id){

        $detalles = DetalleCotizacion::findOrFail($id)->where('id_cotizacion', $this->cotizacion->id)->get();

            for ($i=0; $i < count($detalles); $i++) {
                $detalles[$i]->delete();
            }

            this->emit('actualizar');
           // return view('compras.cotizaciones.detalle');
    }

}
