<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class TdDropdown extends Component
{

    public $estilo, $colortxt, $colorbg;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($estilo = 'bs', $colortxt ="text-blue-500", $colorbg="border-blue-500")
    {
        //
        $this->estilo = $estilo;
        $this->colortxt = $colortxt;
        $this->colorbg = $colorbg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.td-dropdown');
    }
}
