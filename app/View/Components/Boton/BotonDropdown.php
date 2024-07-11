<?php

namespace App\View\Components\Boton;

use Illuminate\View\Component;

class BotonDropdown extends Component
{

    public $icon, $text, $modo;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $text, $modo = 'boton')
    {
        //
        $this->icon = $icon;
        $this->text= $text;
        $this->modo = $modo;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.boton.boton-dropdown');
    }
}
