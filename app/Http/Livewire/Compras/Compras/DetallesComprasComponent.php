<?php

namespace App\Http\Livewire\Compras\Compras;

use App\Models\Compras\Compra;
use App\Models\Compras\DetalleCompra;
use App\Models\Compras\DetalleOferta;
use Livewire\Component;
use App\Models\Compras\Oferta;
use App\Models\Planificacion\PlanDetalle;

class DetallesComprasComponent extends Component
{
    public $id_oferta, $compra, $proveedor, $id_centro_costo;
    public $porc_iva = 16;
    public $porc_ret_iva = 75;
    public $subtotal, $monto_imput_iva, $iva, $total, $pago_neto;
    public $ofertas, $centros, $detalles;

    protected $listeners = [
        'actualizar:compra' => '$refresh'
    ];

    public function render()
    {
        $compra = Compra::findOrFail($this->compra->id);

        //Si ya hay detalle de compra
        if ($this->compra->proveedor != null)
        {
            $this->fill([
                'centros' => PlanDetalle::all('id', 'codificacion'),
                'proveedor' => $this->compra->proveedor->nombre
            ]);

            $detalles =  DetalleCompra::where('id_compra', $this->compra->id)->get();
        }
        //Si no hay detalle de compra
        else
        {
            $this->fill([
                'ofertas' => Oferta::where('id_cotizacion', $this->compra->id_cotizacion)
                                    ->where('estatus', 'ACEPTADA')
                                    ->orderBy('id', 'ASC')
                                    ->get(),
                'centros' => PlanDetalle::all('id', 'codificacion')
            ]);

            $detalles =  DetalleOferta::where('id_oferta', $this->id_oferta)->get();
        }
        
        $subtotal = 0;
        $subtotal_iva = 0;
        $iva = 0;
        $ret_iva = 0;
        $total = 0;
        $neto = 0;
        $existe_exento_iva = false;
        
        for ($i = 0; $i < $detalles->count(); $i++)
        {
            $subtotal += ($detalles[$i]->precio * $detalles[$i]->cantidad_ofertada);
            if($detalles[$i]->exento_iva == false)
            {
                $subtotal_iva += ($detalles[$i]->precio * $detalles[$i]->cantidad_ofertada);
                $existe_exento_iva = true;
            }
        }
        if ($existe_exento_iva == true)
        {
            $iva =( $subtotal_iva * 16) / 100;
            $this->monto_imput_iva = $subtotal_iva;
        }
        else
        {
            $iva =( $subtotal * 16) / 100;
            $this->monto_imput_iva = $subtotal;
        }
            
        $total = $subtotal + $iva;
        $ret_iva = ($iva * 75) / 100;
        $pago_neto = $total - $ret_iva;

        $this->subtotal = $subtotal;
        $this->iva = $iva;
        $this->total = $total;
        $this->pago_neto = $pago_neto;
        $this->detalles = $detalles;

        return view('livewire.compras.compras.detalles-compras-component', compact('compra','detalles','subtotal','iva','total', 'ret_iva', 'pago_neto'));

    }

    public function guardar (){

        if ($this->id_oferta == -1){
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'Ingrese un proveedor'
            ]);
        }
        else
        {
          

            $detalles_com = DetalleCompra::all();

            foreach ($detalles_com as $detalle_com) {
                if ($detalle_com->id_oferta == $this->id_oferta) {
                    $this->dispatchBrowserEvent('errorAlert', [
                        'title' => 'Error',
                        'message' => 'La oferta ya se encuentra agregada'
                    ]);
                    return;
                }
            }
            
            $this->detalles = DetalleOferta::where('id_oferta', '=', $this->id_oferta)->get();

            for ($i=0; $i < count($this->detalles); $i++) {
                DetalleCompra::create
                ([
                    'id_compra' => $this->compra->id,
                    'id_detalle_oferta' => $this->detalles[$i]->id,
                    'id_centro_costo' => rand(1, 2),
                ]);
            }

            $oferta = Oferta::findOrFail($this->id_oferta);
            Compra::UpdateOrCreate(
                ['id' => $this->compra->id],
                [
                    'id_proveedor' => $oferta->id_proveedor,
                    'porc_iva' => $this->porc_iva,
                    'porc_ret_iva' => $this->porc_ret_iva,
                    'subtotal' => $this->subtotal,
                    'monto_imput_iva' => $this->monto_imput_iva,
                    'total' => $this->total,
                    'pago_neto' => $this->pago_neto,
                ]
            );

            $this->emit('actualizar:compra');


        }
    }

}
