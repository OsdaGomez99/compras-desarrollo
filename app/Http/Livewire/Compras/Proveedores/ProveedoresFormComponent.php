<?php

namespace App\Http\Livewire\Compras\Proveedores;

use App\Models\Compras\Proveedor;
use App\Models\Global\TipoPersona;
use App\Models\Global\TipoEmpresa;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProveedoresFormComponent extends Component
{
    public $id_proveedor, $nombre, $rif, $representante, $telefono, $telefono_alt,
    $email, $direccion, $num_rnc, $nro_alsobocaroni, $cod_grupo_alsobocaroni,
    $ruc_alsobocaroni, $tipo_persona_seleccionada, $tipo_empresa_seleccionada;
    public $user, $user_id;
    public $personas, $empresas;
    public $mode_edit;

    public $listeners = [
        'actualizar:proveedores' => '$refresh'
    ];

    public $rules = [
        'nombre' => 'required',
        'rif' => 'required|rif',
        'email' => 'required|email',
        'representante' => 'required',
        'telefono' => 'required|telefono',
        'direccion' => 'required',
        'tipo_persona_seleccionada' => 'required'
    ];

    public function render()
    {
        $this->fill([
            'personas' => TipoPersona::all(['id', 'descripcion'])->sortBy('id'),
            'empresas' => TipoEmpresa::all(['id', 'abreviatura'])->sortBy('id'),
        ]);
        return view('livewire.compras.proveedores.proveedores-form-component');
    }

    public function mount ($id)
    {
        if ($id)
        {
            $proveedor = Proveedor::findOrFail($id);

            $this->fill([
                'mode_edit' => true,
                'id_proveedor' => $id,
                'nombre' => $proveedor->nombre,
                'rif' => $proveedor->rif,
                'representante' => $proveedor->representante,
                'telefono' => $proveedor->telefono,
                'telefono_alt' => $proveedor->telefono_alt,
                'email' => $proveedor->email,
                'direccion' => $proveedor->direccion,
                'num_rnc' => $proveedor->num_rnc,
                'nro_alsobocaroni' => $proveedor->nro_alsobocaroni,
                'cod_grupo_alsobocaroni' => $proveedor->cod_grupo_alsobocaroni,
                'ruc_alsobocaroni' => $proveedor->ruc_alsobocaroni,
                'tipo_persona_seleccionada' => $proveedor->id_tipo_persona,
                'tipo_empresa_seleccionada' => $proveedor->id_tipo_empresa,
            ]);

            $this->emitSelf('actualizar:proveedores');
        }
        else
        {
            $this->id_proveedor = -1;
            $this->mode_edit = false;
        }
    }

    public function guardar()
    {
        $this->user = Auth::user();

        if ($this->id_proveedor == -1){

            $this->validate();

            Proveedor::Create(
                [
                    'nombre' => $this->nombre,
                    'rif' => $this->rif,
                    'representante' => $this->representante,
                    'telefono' => $this->telefono,
                    'telefono_alt' => $this->telefono_alt,
                    'email' => $this->email,
                    'direccion' => $this->direccion,
                    'num_rnc' => $this->num_rnc,
                    'nro_alsobocaroni' => $this->nro_alsobocaroni,
                    'cod_grupo_alsobocaroni' => $this->cod_grupo_alsobocaroni,
                    'ruc_alsobocaroni' => $this->ruc_alsobocaroni,
                    'id_tipo_persona' => $this->tipo_persona_seleccionada,
                    'id_tipo_empresa' => $this->tipo_empresa_seleccionada,
                    'user_id' => $this->user->id
                ]
            );

        } else {

            $this->validate([
                'nombre' => 'required',
                'rif' => 'required|rif',
                'email' => 'required|email',
                'representante' => 'required',
                'telefono' => 'required|telefono',
                'direccion' => 'required',
                'tipo_persona_seleccionada' => 'required',
            ]);

            Proveedor::UpdateOrCreate(
                ['id' => $this->id_proveedor],
                [
                    'nombre' => $this->nombre,
                    'rif' => $this->rif,
                    'representante' => $this->representante,
                    'telefono' => $this->telefono,
                    'telefono_alt' => $this->telefono_alt,
                    'email' => $this->email,
                    'direccion' => $this->direccion,
                    'num_rnc' => $this->num_rnc,
                    'nro_alsobocaroni' => $this->nro_alsobocaroni,
                    'cod_grupo_alsobocaroni' => $this->cod_grupo_alsobocaroni,
                    'ruc_alsobocaroni' => $this->ruc_alsobocaroni,
                    'id_tipo_persona' => $this->tipo_persona_seleccionada,
                    'id_tipo_empresa' => $this->tipo_empresa_seleccionada
                ]
            );
        }

        $mensaje = ($this->id_proveedor == -1) ? '[+] Proveedor Ingresado Correctamente.' : '[+] Proveedor Modificado Correctamente.';

        return redirect()->route('proveedores.index')->with('success', $mensaje);

    }
}
