<?php

namespace App\Http\Livewire\Compras\Cotizaciones;

use App\Models\Compras\Cotizacion;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CotizacionesFormComponent extends Component
{
    public $id_cot, $numero, $fecha_cotizacion, $fecha_vigencia, $fecha_tope, $hora_tope, $fecha_visita, $hora_visita,
    $lugar_visita, $estatus, $user;
    public $mode_edit, $tipo;
    public $fecha_actual;

    public $listeners = [
        'actualizar:cotizacion' => '$refresh'
    ];

    protected $rules = [
        'fecha_vigencia' => 'required',
    ];

    public function render()
    {
        return view('livewire.compras.cotizaciones.cotizaciones-form-component');
    }

    public function mount ($id, $tipo)
    {
        if ($id && $tipo)
        {
            $cotizacion = Cotizacion::findOrFail($id);

            $this->fill([
                'mode_edit' => true,
                'tipo' => $tipo,
                'id_cot' => $id,
                'numero' => $cotizacion->numero,
                'fecha_cotizacion' => $cotizacion->fecha_cotizacion,
                'fecha_vigencia' => $cotizacion->fecha_vigencia,
                'fecha_tope' => $cotizacion->fecha_tope,
                'hora_tope' => $cotizacion->hora_tope,
                'fecha_visita' => $cotizacion->fecha_visita,
                'hora_visita' => $cotizacion->hora_visita,
                'lugar_visita' => $cotizacion->lugar_visita,
                'estatus' => $cotizacion->estatus,
            ]);

            $this->emitSelf('actualizar:cot');
        }
        else
        {
            $result = DB::table('compras.cotizaciones')
                ->select(DB::raw('count(*) as cont'))
                ->whereMonth('fecha_cotizacion', '=', date('n'))
                ->where('tipo', '=', $tipo)

                ->get();
            $cont = $result[0]->cont + 1; //incrementas
            $mes = cambiarMes($this->fecha_cotizacion);
            $num = sprintf("%'.05d", $cont); // formato con 5 digitos */

            $this->fill([
                'numero' => date("Y").$mes.$num,
                'fecha_actual' => Carbon::now()->format('Y-m-d'),
                'fecha_cotizacion' => Carbon::now()->format('Y-m-d'),
            ]);


            $this->id_cot = -1;
            $this->mode_edit = false;
            $this->tipo = $tipo;
        }
    }

    public function updatedFechaCotizacion()
    {
        $result = DB::table('compras.cotizaciones')
        ->select(DB::raw('count(*) as cont'))
        ->whereMonth('fecha_cotizacion', '=', Carbon::createFromFormat('Y-m-d', $this->fecha_cotizacion)->format('n'))
        ->first();

        $cont = $result->cont + 1; //incrementas
        $mes = cambiarMes($this->fecha_cotizacion);
        $num = sprintf("%'.05d", $cont); // formato con 5 digitos */

        $this->numero = Carbon::createFromFormat('Y-m-d', $this->fecha_cotizacion)->format('Y').$mes.$num;
    }


    public function limpiarForm()
    {
        $this->numero = null;
        $this->fecha_cotizacion = null;
        $this->fecha_vigencia = null;
    }


    public function guardar ()
    {
        $this->user = Auth::user();
        $this->validate();

        if ($this->id_cot == -1)
        {
            Cotizacion::create([
                'tipo' => $this->tipo,
                'numero' => $this->numero,
                'fecha_cotizacion' => $this->fecha_cotizacion,
                'fecha_vigencia' => $this->fecha_vigencia,
                'fecha_tope' => $this->fecha_tope,
                'hora_tope' => $this->hora_tope,
                'fecha_visita' => $this->fecha_visita,
                'hora_visita' => $this->hora_visita,
                'lugar_visita' => $this->lugar_visita,
                'estatus' => 'TRANSCRITA',
                'user_id' => $this->user->id
            ]);
        } else{

            Cotizacion::UpdateOrCreate(
                ['id' => $this->id_cot],
                [
                    'numero' => $this->numero,
                    'fecha_cotizacion' => $this->fecha_cotizacion,
                    'fecha_vigencia' => $this->fecha_vigencia,
                    'fecha_tope' => $this->fecha_tope,
                    'hora_tope' => $this->hora_tope,
                    'fecha_visita' => $this->fecha_visita,
                    'hora_visita' => $this->hora_visita,
                    'lugar_visita' => $this->lugar_visita,
                ]
            );
        }

        $mensaje = ($this->id_cot == -1 ? '[+] Cotización Ingresada Correctamente.' : '[*] Cotización Modificada Correctamente.');

        return redirect()->route('cotizaciones.index')->with('success', $mensaje);
    }
}
