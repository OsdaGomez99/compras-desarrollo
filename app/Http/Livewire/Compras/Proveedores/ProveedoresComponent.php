<?php

namespace App\Http\Livewire\Compras\Proveedores;
use App\Models\Compras\Proveedor;
use Livewire\WithPagination;

use Livewire\Component;

class ProveedoresComponent extends Component
{
    use WithPagination;
    public $busqueda;
    protected $queryString = ['busqueda'];
    public $detalle_nombre, $detalle_proveedor;

    protected $listeners = [
        'proveedor:changeStatus' => 'changeStatus',
        'proveedor:busqueda' => 'busqueda'
    ];

    public function render()
    {
        if ($this->busqueda) {

        $proveedores = Proveedor::search($this->busqueda)
                                ->orderBy('nombre', 'asc')
                                ->where('status', '=', 'true')
                                ->paginate(10);
        } else {
        $proveedores = Proveedor::orderBy('nombre', 'asc')
                                ->where('status', '=', 'true')
                                ->paginate(10);
        }

        return view('livewire.compras.proveedores.proveedores-component', compact('proveedores'));
    }

    public function busqueda($busqueda)
    {
        $this->busqueda = $busqueda;
    }

    public function detalleProveedor($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $persona = $proveedor->persona->descripcion;

        if ($this->detalle_nombre != $proveedor->nombre) {

            $this->fill([
                'detalle_nombre' => $proveedor->nombre,
                'detalle_proveedor' => [
                    "Nombre: $proveedor->nombre",
                    "RIF: $proveedor->rif",
                    "Representante: $proveedor->representante",
                    "Telefono: $proveedor->telefono",
                    "Telefono Alternativo: $proveedor->telefono",
                    "Email: $proveedor->email",
                    "Dirección: $proveedor->direccion",
                    "Nro. de RNC: $proveedor->num_rnc",
                    "Nro. de ALSOBOCARONI: $proveedor->nro_alsobocaroni",
                    "Cod. Grupo ALSOBOCARONI: $proveedor->cod_grupo_alsobocaroni",
                    "RUC de ALSOBOCARONI: $proveedor->ruc_alsobocaroni",
                    "Cuenta Contable: $proveedor->id_cuenta_contable",
                    "Tipo de Persona: $persona",
                    "Usuario: $proveedor->id_user",

                ],
            ]);

        } else {
            $this->fill([
                'detalle_nombre' => '',
                'detalle_proveedor' => ''
            ]);
        }
    }

    public function changeConfirm(Proveedor $proveedor)
    {
        if($proveedor)
        {
            $this->dispatchBrowserEvent('changeConfirm', [
                'title' => '¿Estas seguro?',
                'message' => 'Que quieres eliminar el proveedor <strong>' . $proveedor->nombre . '</strong>',
                'id' => $proveedor->id,
                'modulo' => 'proveedor'
            ]);


        }
    }

    public function changeStatus($id)
    {
        $proveedor = Proveedor::find($id);
        $proveedor->status = false;
        $proveedor->save();
    }

}
