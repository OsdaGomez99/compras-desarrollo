<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class TableHeader extends Component
{

    public $encabezados = [];
    public $anchos = [];
    public $colspan = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($encabezados, $anchos = null, $colspan = null)
    {
        //
        $this->encabezados = $encabezados;
        $this->anchos = $anchos;
        $this->colspan = $colspan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.table-header');
    }
}
