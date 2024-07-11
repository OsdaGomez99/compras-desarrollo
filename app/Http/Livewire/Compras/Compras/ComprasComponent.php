<?php

namespace App\Http\Livewire\Compras\Compras;
use App\Models\Compras\Compra;
use App\Models\Compras\DetalleCompra;
use Livewire\WithPagination;

use Livewire\Component;

class ComprasComponent extends Component
{
    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_descripcion, $detalle_compra;

    public $listeners = [
        'compra:busqueda' => 'busqueda',
        'compra:aprobarData' => 'aprobarData',
        'compra:deleteData' => 'deleteData',
        'compra:actualizar' => '$refresh'
    ];

    public function render()
    {
        if ($this->busqueda) {
            $compras = Compra::search($this->busqueda)
                            ->where('estatus', '!=', 'ELIMINADA')
                            ->orderBy('id', 'desc')
                            ->paginate(10);
        } else {
            $compras = Compra::search($this->busqueda)
                            ->where('estatus', '!=', 'ELIMINADA')
                            ->orderBy('id', 'desc')
                            ->paginate(10);
        }
        return view('livewire.compras.compras.compras-component', compact('compras'));
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function detalleCompra ($id)
    {
        $compra = Compra::with(['cotizacion'])->findOrFail($id);
        $cotizacion = $compra->cotizacion->numero;

        if ($this->detalle_descripcion != $compra->numero) {

            $this->fill([
                'detalle_descripcion' => $compra->numero,
                'detalle_compra' => [
                    "Nro. Compra: $compra->numero",
                    "Fecha de Compra: $compra->fecha_compra",
                    "Nro. Cotización: $cotizacion",
                ],
            ]);

        } else {
            $this->fill([
                'detalle_descripcion' => '',
                'detalle_compra' => ''
            ]);
        }

    }

    //Funcion de Eliminar Compra
    public function deleteConfirm(Compra $com)
    {
        if ($com->estatus == 'TRANSCRITA')
        {
            $this->dispatchBrowserEvent('deleteConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar la compra <strong>' . $com->numero,
                'id' => $com->id,
                'modulo' => 'compra'
            ]);
        }
        else
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'No se puede eliminar',
                'message' => 'La compra <strong>' . $com->numero . '</strong> no se puede eliminar porque ya fue procesada',
            ]);
        }

    }

    public function deleteData($id)
    {
        $com = Compra::findOrFail($id);
        $com->estatus = 'ELIMINADA';
        $com->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Eliminada!',
            'message' => 'La compra <strong>' . $com->numero . '</strong> ha sido eliminada con éxito.'
        ]);
    }

    public function aprobarConfirm(Compra $com)
    {
        $detalles = DetalleCompra::where('id_compra', '=', $com->id)
                                    ->get();

        if ($com->estatus == 'TRANSCRITA')
        {
            if($detalles->count() < 1)
            {
                $this->dispatchBrowserEvent('errorAlert', [
                    'title' => 'Error',
                    'message' => 'La compra <strong>' . $com->numero . '</strong> no se puede aprobar porque no tiene detalles agregados</strong>'
                ]);
            }
            else
            {
                $this->dispatchBrowserEvent('aprobarConfirm', [
                    'title' => '¿Estas seguro?',
                    'message' => 'Que quieres aprobar la compra <strong>' . $com->numero,
                    'id' => $com->id,
                    'modulo' => 'compra'
                ]);
            }


        } else {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'La compra <strong>' . $com->numero . '</strong> no se puede aprobar porque su estatus es <strong>' . $com->estatus . '</strong>'
            ]);
        }
    }

    public function aprobarData($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->estatus = 'APROBADA COMPRAS';
        $compra->save();

        $this->dispatchBrowserEvent('eventSuccess', [
            'title' => 'Aprobado!',
            'message' => 'La compra <strong>' . $compra->numero . '</strong> ha sido aprobada con éxito.'
        ]);
    }
}
