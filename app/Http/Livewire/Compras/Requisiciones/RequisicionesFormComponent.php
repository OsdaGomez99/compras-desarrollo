<?php

namespace App\Http\Livewire\Compras\Requisiciones;

use App\Models\Compras\Linea;
use App\Models\Compras\Requisicion;
use App\Models\Planificacion\UnidadEjecutora;
use App\Models\Planificacion\AnnoFiscal;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequisicionesFormComponent extends Component
{

    public $id_req, $fecha_requisicion, $numero, $trimestre,
    $estatus, $id_anno, $id_solicitante, $id_linea, $id_prioridad = 1, $justificacion, $user, $user_id;
    public $solicitantes, $centros_costo, $lineas, $annos;
    public $mode_edit, $tipo;
    public $fecha_actual;

    protected $listeners = [
        'actualizar:requisicion' => '$refresh'
    ];

    public function render()
    {

        $this->fill([
            'solicitantes' => UnidadEjecutora::all('id', 'nombre')->sortBy('descripcion'),
            'lineas' => Linea::select('id', 'descripcion')->where('tipo',$this->tipo)->orderBy('descripcion', 'asc')->get(),
            'annos' => AnnoFiscal::select('id', 'anno')->where('is_activo', true)->orderBy('anno', 'asc')->get(),
        ]);

        return view('livewire.compras.requisiciones.requisiciones-form-component');
    }

    public function mount ($id, $tipo)
    {
        if ($id && $tipo)
        {
            $requisicion = Requisicion::findOrFail($id);

            $this->fill([
                'mode_edit' => true,
                'tipo' => $tipo,
                'id_req' => $id,
                'fecha_requisicion' => $requisicion->fecha_requisicion,
                'trimestre' => $requisicion->trimestre,
                'numero' => $requisicion->numero,
                'id_anno' => $requisicion->id_anno,
                'estatus' => $requisicion->estatus,
                'id_solicitante' => $requisicion->id_solicitante,
                'id_linea' => $requisicion->id_linea,
                'id_prioridad' => $requisicion->id_prioridad,
                'justificacion' => $requisicion->justificacion,
                'fecha_actual' => Carbon::now()->format('Y-m-d'),
            ]);
        }
        else
        {
            $result = DB::table('compras.requisiciones')
                ->select(DB::raw('count(*) as cont'))
                ->whereMonth('fecha_requisicion', '=', date('n'))
                ->where('tipo', '=', $tipo)
                ->get();
            $cont = $result[0]->cont + 1; //incrementas
            $mes = cambiarMes($this->fecha_requisicion);
            $num = sprintf("%'.05d", $cont); // formato con 5 digitos */

            $this->fill([
                'numero' => date("Y").$mes.$num,
                'fecha_actual' => Carbon::now()->format('Y-m-d'),
                'fecha_requisicion' => Carbon::now()->format('Y-m-d'),
                'trimestre' => trimestre(Carbon::now()->format('Y-m-d')),
                'prioridad' => $this->id_prioridad
            ]);

            $this->id_req = -1;
            $this->mode_edit = false;
            $this->tipo = $tipo;
        }
    }

    public function updatedFechaRequisicion()
    {
        $result = DB::table('compras.requisiciones')
        ->select(DB::raw('count(*) as cont'))
        ->whereMonth('fecha_requisicion', '=', Carbon::createFromFormat('Y-m-d', $this->fecha_requisicion)->format('n'))
        ->where('tipo', '=', $this->tipo)
        ->first();


        $cont = $result->cont + 1; //incrementas
        $mes = cambiarMes($this->fecha_requisicion);
        $num = sprintf("%'.05d", $cont); // formato con 5 digitos */

        $this->numero = Carbon::createFromFormat('Y-m-d', $this->fecha_requisicion)->format('Y').$mes.$num;
        $this->trimestre = trimestre($this->fecha_requisicion);
    }

    public function guardar ()
    {
        $this->user = Auth::user();

        if ($this->id_solicitante == null || $this->id_linea == null || $this->id_anno == null)
        {
            $this->dispatchBrowserEvent('errorAlert', [
                'title' => 'Error',
                'message' => 'Verifique que los campos obligatorios esten completos'
            ]);
        }
        else
        {
            if ($this->id_req == -1)
            {
                Requisicion::create([
                    'tipo' => $this->tipo,
                    'fecha_requisicion' => $this->fecha_requisicion,
                    'numero' => $this->numero,
                    'id_anno' => $this->id_anno,
                    'trimestre' => $this->trimestre,
                    'estatus' => 'TRANSCRITA',
                    'id_solicitante' => $this->id_solicitante,
                    'id_linea' => $this->id_linea,
                    'id_prioridad' => $this->id_prioridad,
                    'justificacion' => $this->justificacion,
                    'user_id' => $this->user->id
                ]);
            }
            else
            {
                Requisicion::UpdateOrCreate(
                    ['id' => $this->id_req],
                    [
                        'fecha_requisicion' => $this->fecha_requisicion,
                        'numero' => $this->numero,
                        'id_anno' => $this->id_anno,
                        'trimestre' => $this->trimestre,
                        'id_solicitante' => $this->id_solicitante,
                        'id_linea' => $this->id_linea,
                        'id_prioridad' => $this->id_prioridad,
                        'justificacion' => $this->justificacion,
                    ]
                );
            }

            $mensaje = ($this->id_req == -1 ? '[+] Requisición Ingresada Correctamente.' : '[*] Requisición Modificada Correctamente.');

            return redirect()->route('requisiciones.index')->with('success', $mensaje);
        }

    }


}
