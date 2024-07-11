<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BusquedaComponent extends Component
{

    public $modulo;
    public $busqueda;

    public function render()
    {
        return view('livewire.busqueda-component');
    }

    public function updatedBusqueda(){
        $this->emit("$this->modulo:busqueda", $this->busqueda);
    }

}
