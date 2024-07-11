<?php

namespace App\Http\Livewire\Compras\Lineas;
use App\Models\Compras\Linea;
use Livewire\WithPagination;

use Livewire\Component;

class LineasComponent extends Component
{
    use WithPagination;

    public $busqueda;
    protected $queryString = ['busqueda'];
    public $descripcion;

    protected $listeners = [
        'linea:actualizar' => 'actualizar',
        'linea:changeStatus' => 'changeStatus',
        'linea:limpiaFormlinea' => 'limpiaFormLinea',
        'linea:busqueda' => 'busqueda'
    ];

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function render()
    {
        $data_select = ['id', 'descripcion', 'tipo'];

        if ($this->busqueda) {

            $lineas = Linea::select($data_select)
                ->search($this->busqueda)
                ->where('status', '=', 'true')
                ->orderBy('descripcion', 'asc')
                ->paginate(10);
        } else {
            $lineas = Linea::select($data_select)
                ->where('status', '=', 'true')
                ->orderBy('descripcion', 'asc')
                ->paginate(10);
        }

        return view('livewire.compras.lineas.lineas-component', compact('lineas'));
    }

    public function actualizar($tipo, $mensaje)
    {
        $this->limpiaFormLinea();
        session()->flash($tipo, $mensaje);
    }

    public function limpiaFormLinea(){
        $this->fill([
            'descripcion' => ''
        ]);
    }

    public function changeConfirm(Linea $linea)
    {
        if($linea)
        {
            $this->dispatchBrowserEvent('changeConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar la línea <strong>' . $linea->descripcion . '</strong>',
                'id' => $linea->id,
                'modulo' => 'linea'
            ]);
        }
    }

    public function changeStatus($id)
    {
        $linea = Linea::find($id);
        $linea->status = false;
        $linea->save();

        session()->flash('success', '[*] Registro Eliminado Correctamente.');
    }

}
