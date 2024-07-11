<?php

namespace App\Http\Livewire\Compras\Ofertas;

use Livewire\Component;
use App\Models\Compras\Oferta;

class OfertasFormComponent extends Component
{
    public $id_oferta, $tipo;
    public $id_cotizacion, $id_proveedor, $estatus, $fecha_entrega, $fecha_recepcion,
    $fecha_oferta, $fecha_vigencia, $condiciones_venta, $descuento, $van;

    public $listeners = [
        'actualizar:oferta' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.compras.ofertas.ofertas-form-component');
    }

    public function mount ($id, $tipo)
    {
        if ($id && $tipo)
        {
            $oferta = Oferta::with('cotizacion', 'proveedor')->findOrFail($id);

            $this->fill([
                'id_oferta' => $id,
                'tipo'=> $tipo,
                'id_cotizacion' => $oferta->cotizacion->numero,
                'id_proveedor' => $oferta->proveedor->nombre,
                'fecha_entrega' => $oferta->fecha_entrega,
                'fecha_recepcion' => $oferta->fecha_recepcion,
                'fecha_oferta' => $oferta->fecha_oferta,
                'fecha_vigencia' => $oferta->fecha_vigencia,
                'condiciones_venta' => $oferta->condiciones_venta,
                'descuento' => $oferta->descuento,
                'van' => $oferta->van,
                'estatus' => $oferta->estatus,
            ]);
        }
        else
        {
            $this->id_oferta = -1;
            $this->tipo = $tipo;
        }
    }

    public function guardar ()
    {

        Oferta::UpdateOrCreate(
            ['id' => $this->id_oferta],
            [
                'fecha_entrega' => $this->fecha_entrega,
                'fecha_recepcion' => $this->fecha_recepcion,
                'fecha_oferta' => $this->fecha_oferta,
                'fecha_vigencia' => $this->fecha_vigencia,
                'condiciones_venta' => $this->condiciones_venta,
                'descuento' => $this->descuento,
                'van' => $this->van,
            ]
        );

        $mensaje = '[*] Oferta Modificada Correctamente.';

        return redirect()->route('ofertas.index')->with('success', $mensaje);

    }
}
