<?php

namespace App\View\Components\Table;

use Illuminate\View\Component;

class TdDetalle extends Component
{

    public string $id;
    public int $colspan;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $colspan=0)
    {
        //
        $this->id = $id;
        $this->colspan = $colspan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table.td-detalle');
    }
}
