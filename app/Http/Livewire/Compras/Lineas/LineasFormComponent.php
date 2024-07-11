<?php

namespace App\Http\Livewire\Compras\Lineas;

use Livewire\Component;
use App\Models\Compras\Linea;

class LineasFormComponent extends Component
{
    public $modal = false;
    public $id_linea, $descripcion, $tipo;

    protected $rules = [
        'descripcion' => 'required',
    ];

    protected $listeners = [
        'actualizar' => '$refresh',
        'editLinea' => 'editar',
    ];

    public function render()
    {
        return view('livewire.compras.lineas.lineas-form-component');
    }

    public function actualizar($tipo, $mensaje)
    {
        $this->limpiaFormLinea();
        session()->flash($tipo, $mensaje);
    }

    public function create($tipo)
    {
        $this->id_linea = -1;
        $this->tipo = $tipo;
        $this->limpiarCampos();
        $this->abrirModal();
    }

    public function limpiarCampos()
    {
        $this->fill([
            'descripcion' => '',
        ]);
    }

    public function abrirModal()
    {
        $this->modal = true;
        $this->dispatchBrowserEvent('limpiaForm-linea');
        $this->emit('linea:limpiaFormlinea');
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        if ($this->id_linea == -1) {
            $this->validate();

            $linea = Linea::where('descripcion', $this->descripcion)->first();
            if($linea)
            {
                $linea->status = true;
                $linea->save();
            }
            else
            {
                Linea::create([
                    'descripcion' => strtoupper($this->descripcion),
                    'tipo' => $this->tipo,
                ]);
            }

        } else {
            $this->validate([
                'descripcion' => 'required',
            ]);

            $linea = Linea::where('descripcion', $this->descripcion)->first();
            if($linea)
            {
                $linea->status = true;
                $linea->save();
            }
            else
            {

                Linea::updateOrCreate(
                    ['id' => $this->id_linea],
                    [
                        'descripcion' => $this->descripcion,
                    ]
                );
            }
        }

        //Mensaje de registro exitoso
        $mensajes = ($this->id_linea == -1 ? '[+] Registro Ingresado Correctamente.' : '[*] Registro Modificado Correctamente.');

        $this->limpiarCampos();
        $this->emit('linea:actualizar', 'success', $mensajes);

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $linea = Linea::findOrFail($id);
        $this->fill([
            'id_linea' => $id,
            'descripcion' => $linea->descripcion,
        ]);
        $this->abrirModal();
        $this->emit('linea:limpiaFormlinea');
    }

}
