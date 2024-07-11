<?php

namespace App\View\Components\Boton;

use Illuminate\View\Component;

class BotonAgregar extends Component
{

    public $title;
    public $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $link = null)
    {
        //
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.boton.boton-agregar');
    }
}
