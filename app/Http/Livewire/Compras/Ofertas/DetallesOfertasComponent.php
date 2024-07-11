<?php

namespace App\Http\Livewire\Compras\Ofertas;

use Livewire\Component;
use App\Models\Compras\DetalleOferta;

class DetallesOfertasComponent extends Component
{
    public $oferta;
    public $edit = false, $id_detalle, $cantidad_ofertada2, $precio2, $exento_iva2;

    public function render()
    {

        $detalles = DetalleOferta::where('id_oferta', $this->oferta->id)
                                ->orderBy('id', 'ASC')
                                ->get();

        return view('livewire.compras.ofertas.detalles-ofertas-component', compact('detalles'));
    }

    public function edit($id)
    {
        if($id)
        {
            $this->id_detalle = $id;
            $detalle = DetalleOferta::findOrFail($id);
            $this->fill([
                'cantidad_ofertada2' => $detalle->cantidad_ofertada,
                'precio2' => $detalle->precio,
                'exento_iva2' => $detalle->exento_iva,
            ]);
        }

        $this->edit = true;
    }

    public function guardarData($id)
    {
        $detalle = DetalleOferta::findOrFail($id);
        if($this->cantidad_ofertada2 > $detalle->cantidad_cotizada)
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La cantidad ofertada debe ser igual o menor a la cantidad cotizada'
            ]);
        }
        else
        {
            $detalle->cantidad_ofertada = $this->cantidad_ofertada2;
            $detalle->precio = $this->precio2;
            $detalle->exento_iva = $this->exento_iva2;
            $detalle->save();
        }

        $this->id_detalle = null;
        $this->edit = false;
    }
}
