<?php

namespace App\Http\Livewire\Compras\Requisiciones;

use App\Models\Compras\DetalleRequisicion;
use App\Models\Compras\Articulo;
use App\Models\Global\UnidadMedida;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetallesRequisicionesComponent extends Component
{
    public $requisicion; //requisicion perteneciente al detalla
    public $id_articulo, $descripcion, $id_unidad_medida, $cantidad; //variables para imputs
    public $articulos, $unidades; //selects
    public $edit_cantidad = false, $id_detalle, $cantidad2; //editar campos

    protected $listeners = [
        'detalle:deleteData' => 'deleteData',
        'detalle:edit' => 'edit',
        'detalle:editData' => 'editData',
        'actualizar' => '$refresh'
    ];

    public function render()
    {
        $this->fill([
            'articulos' => Articulo::select('id', 'descripcion', 'id_unidad_medida')
                                ->with('medida','linea')
                                ->where('id_linea', $this->requisicion->id_linea)
                                ->orderBy('descripcion', 'ASC')
                                ->get(),
            'unidades' => UnidadMedida::all('id', 'codigo', 'descripcion')->sortBy('descripcion'),
        ]);

        $detalles = DetalleRequisicion::where('id_requisicion', $this->requisicion->id)
                                    ->with('requisicion', 'articulo')
                                    ->orderBy('id', 'ASC')
                                    ->get();

        return view('livewire.compras.requisiciones.detalles-requisiciones-component', compact('detalles'));
    }

    public function actualizar($tipo, $mensaje)
    {
        $this->fill([
            'cantidad' => null
        ]);
        session()->flash($tipo, $mensaje);
    }

    public function deleteData($id)
    {
        $detalle = DetalleRequisicion::findOrFail($id);
        $detalle->delete();

        $this->emit('actualizar');
    }

    public function edit($id)
    {
        if($id)
        {
            $this->id_detalle = $id;
            $detalle = DetalleRequisicion::findOrFail($id);
            $this->fill([
                'cantidad2' => $detalle->cantidad,
            ]);
        }

        $this->edit_cantidad = true;
    }

    public function guardarData($id)
    {
        if ($this->cantidad2 == null || $this->cantidad2 == 0)
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'Verifique que el campo cantidad sea mayor a cero'
            ]);
        }
        else
        {
            $detalle = DetalleRequisicion::findOrFail($id);
            $detalle->cantidad = $this->cantidad2;
            $detalle->save();

        }
        $this->id_detalle = null;
        $this->edit_cantidad = false;
    }

    public function guardar(DetalleRequisicion $detalle)
    {
        if ( $this->requisicion->tipo == 'BIENES')
        {
            if ($this->id_articulo == null || $this->cantidad == null || $this->cantidad == null){
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'Verifique que todos los campos estén completos'
                ]);
            }
            else
            {
                $exists = DetalleRequisicion::where('id_requisicion', $this->requisicion->id)
                                        ->where('id_articulo', '=', $this->id_articulo)
                                        ->first();

                if ($exists)
                {
                    $existente = DetalleRequisicion::find($exists->id);
                    $existente->cantidad += $this->cantidad;
                    $existente->save();
                }

                else
                {
                    $detalle->id_requisicion = $this->requisicion->id;
                    $detalle->id_articulo = $this->id_articulo;
                    $detalle->cantidad = $this->cantidad;
                    $detalle->save();
                }

                $this->emit('actualizar');
            }
        }
        else
        {
            if ($this->descripcion == null || $this->id_unidad_medida == null || $this->cantidad == null){
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'Verifique que todos los campos estén completos'
                ]);
            }
            else
            {
                $exists = DetalleRequisicion::where('id_requisicion', $this->requisicion->id)
                                            ->where('descripcion', '=', $this->descripcion)
                                            ->first();

                if ($exists)
                {
                    $existente = DetalleRequisicion::find($exists->id);
                    $existente->cantidad += $this->cantidad;
                    $existente->save();
                }

                else
                {
                    $detalle->id_requisicion = $this->requisicion->id;
                    $detalle->descripcion = $this->descripcion;
                    $detalle->id_unidad_medida = $this->id_unidad_medida;
                    $detalle->cantidad = $this->cantidad;
                    $detalle->save();
                }

                $this->emit('actualizar');
            }
        }

    }
}
