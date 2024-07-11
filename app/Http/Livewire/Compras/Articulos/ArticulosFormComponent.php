<?php

namespace App\Http\Livewire\Compras\Articulos;

use App\Models\Compras\Articulo;
use App\Models\Compras\Linea;
use App\Models\Global\UnidadMedida;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticulosFormComponent extends Component
{
    public $id_articulo, $descripcion, $linea_seleccionada, $unidad_seleccionada, $cod_art_ccce, $cod_ocepre, $cod_cnu, $ultimo_precio, $user_id;
    public $lineas, $unidades, $user;
    public $mode_edit;

    public $listeners = [
        'actualizar:articulos' => '$refresh'
    ];

    public function render()
    {
        $this->fill([
            'lineas' => Linea::all(['id', 'descripcion'])->sortBy('descripcion'),
            'unidades' => UnidadMedida::all(['id', 'descripcion'])->sortBy('descripcion'),
        ]);

        return view('livewire.compras.articulos.articulos-form-component');
    }

    public function mount ($id)
    {
        if ($id)
        {
            $articulo = Articulo::findOrFail($id);

            $this->fill([
                'mode_edit' => true,
                'id_articulo' => $id,
                'descripcion' => $articulo->descripcion,
                'linea_seleccionada' => $articulo->id_linea,
                'unidad_seleccionada' => $articulo->id_unidad_medida,
                'cod_art_ccce' => $articulo->cod_art_ccce,
                'cod_ocepre' => $articulo->cod_ocepre,
                'cod_cnu' => $articulo->cod_cnu,
                'ultimo_precio' => $articulo->ultimo_precio,
            ]);

            $this->emitSelf('actualizar:articulos');
        }
        else
        {
            $this->id_articulo = -1;
            $this->mode_edit = false;
        }
    }

    public function limpiarForm()
    {
        $this->descripcion = null;
        $this->linea_seleccionada = null;
        $this->unidad_seleccionada = null;
        $this->cod_art_ccce = null;
        $this->cod_ocepre = null;
        $this->cod_cnu = null;
        $this->ultimo_precio = null;
    }

    public function guardar()
    {
        $this->user = Auth::user();

        if ($this->descripcion == null || $this->linea_seleccionada == null || $this->unidad_seleccionada == null)
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'Verifique que los campos obligatorios estén completos y correctos'
            ]);
        }
        else
        {
            if ($this->id_articulo == -1)
            {
                //si existe un articulo con la misma descripcion, cambiar el status de ese articulo a activo
                $articulo = Articulo::where('descripcion', $this->descripcion)->first();
                if ($articulo) {
                    $articulo->status = true;
                    $articulo->save();
                }
                else
                {
                    Articulo::Create(
                        [
                            'descripcion' => $this->descripcion,
                            'id_linea' => $this->linea_seleccionada,
                            'id_unidad_medida' => $this->unidad_seleccionada,
                            'cod_art_ccce' => $this->cod_art_ccce,
                            'cod_ocepre' => $this->cod_ocepre,
                            'cod_cnu' => $this->cod_cnu,
                            'ultimo_precio' => $this->ultimo_precio,
                            'user_id' => $this->user->id
                        ]
                    );

                }
            }
            else
            {
                $articulo = Articulo::where('descripcion', $this->descripcion)->first();
                if ($articulo) {
                    $articulo->delete();

                    Articulo::UpdateOrCreate(
                        ['id' => $this->id_articulo],
                        [
                            'descripcion' => $this->descripcion,
                            'id_linea' => $this->linea_seleccionada,
                            'id_unidad_medida' => $this->unidad_seleccionada,
                            'cod_art_ccce' => $this->cod_art_ccce,
                            'cod_ocepre' => $this->cod_ocepre,
                            'cod_cnu' => $this->cod_cnu,
                            'ultimo_precio' => $this->ultimo_precio,
                        ]
                    );
                }
                else
                {
                    Articulo::UpdateOrCreate(
                        ['id' => $this->id_articulo],
                        [
                            'descripcion' => $this->descripcion,
                            'id_linea' => $this->linea_seleccionada,
                            'id_unidad_medida' => $this->unidad_seleccionada,
                            'cod_art_ccce' => $this->cod_art_ccce,
                            'cod_ocepre' => $this->cod_ocepre,
                            'cod_cnu' => $this->cod_cnu,
                            'ultimo_precio' => $this->ultimo_precio,
                        ]
                    );
                }
            }

            $mensaje = ($this->id_articulo == -1 ? '[+] Artículo Ingresado Correctamente.' : '[*] Artículo Modificado Correctamente.');

            return redirect()->route('articulos.index')->with('success', $mensaje);
        }

    }

}
