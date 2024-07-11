<?php

namespace App\Http\Livewire\Compras\Articulos;
use App\Models\Compras\Articulo;
use Livewire\WithPagination;

use Livewire\Component;

class ArticulosComponent extends Component
{

    use WithPagination;

    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_descripcion, $detalle_articulo;

    protected $listeners = [
        'articulo:changeStatus' => 'changeStatus',
        'articulo:busqueda' => 'busqueda',
    ];

    public function render()
    {
        if ($this->busqueda) {
        $articulos = Articulo::with('linea', 'medida')
                            ->search($this->busqueda)
                            ->where('status', '=', 'true')
                            ->orderBy('descripcion', 'asc')
                            ->paginate(10);
        } else {
            $articulos = Articulo::with('linea', 'medida')
                                ->where('status', '=', 'true')
                                ->orderBy('descripcion', 'asc')
                                ->paginate(10);
        }

        return view('livewire.compras.articulos.articulos-component', compact('articulos'));
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function detalleArticulo($id)
    {
        $articulo = Articulo::with('linea', 'medida')->findOrFail($id);
        $linea = $articulo->linea->descripcion;
        $unidad = $articulo->medida->codigo;

        if ($this->detalle_descripcion != $articulo->descripcion) {

            $this->fill([
                'detalle_descripcion' => $articulo->descripcion,
                'detalle_articulo' => [
                    "Descripción: $articulo->descripcion",
                    "Último precio: $articulo->ultimo_precio",
                    "Línea: $linea",
                    "Unidad de Medida: $unidad",
                    "Status: $articulo->status",
                    "Código CCCE: $articulo->cod_art_ccce",
                    "Código OCEPRE: $articulo->cod_ocepre",
                    "Código CNU: $articulo->cod_cnu",
                ],
            ]);

        } else {
            $this->fill([
                'detalle_descripcion' => '',
                'detalle_articulo' => ''
            ]);
        }

    }

    public function changeConfirm(Articulo $articulo)
    {
        if($articulo)
        {
            $this->dispatchBrowserEvent('changeConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar el artículo <strong>' . $articulo->descripcion . '</strong>',
                'id' => $articulo->id,
                'modulo' => 'articulo'
            ]);

        }
    }

    public function changeStatus($id)
    {
        $articulo = Articulo::find($id);
        $articulo->status = false;
        $articulo->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Eliminado!',
            'message' => 'El artículo ha sido eliminado con éxito.'
        ]);

        $this->emit('actualizar');
    }

}
