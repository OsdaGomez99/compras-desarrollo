<?php

namespace App\Http\Livewire\Compras\Compras;

use App\Models\Compras\Compra;
use App\Models\Compras\Cotizacion;
use App\Models\Global\FormaPago;
use App\Models\Global\PuntoEnvio;
use App\Models\Global\Adjudicante;
use App\Models\Global\TipoAdjudicacion;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ComprasFormComponent extends Component
{
    public $id_compra, $numero, $fecha_compra, $fecha_actual, $fecha_entrega_mat, $fecha_entrega_oc, $fecha_resolucion_cu, $num_resolucion_cu,
    $id_cotizacion, $nota1, $nota2, $id_forma_pago, $id_punto_envio, $id_adjudicante, $id_tipo_adjudicacion, $req_rendicion = false,
    $num_procedimiento, $fianza_anticipo, $fianza_fiel_comp, $porc_anticipo, $numero_anticipo, $tiempo_anticipo, $user, $estatus;
    public $cotizaciones, $ofertas, $formas_pago, $puntos_envio, $adjudicantes, $adjudicaciones;
    public $mode_edit, $tipo;

    protected $listeners = [
        'actualizar:compra' => '$refresh'
    ];


    public function render()
    {
        $this->fill([
            'cotizaciones' => Cotizacion::select('id', 'numero')->where('tipo', $this->tipo)->get(),
            'formas_pago' => FormaPago::all('id', 'descripcion'),
            'puntos_envio' => PuntoEnvio::all('id', 'descripcion'),
            'adjudicantes' => Adjudicante::all('id', 'nombre'),
            'adjudicaciones' => TipoAdjudicacion::all('id', 'descripcion'),

        ]);
        return view('livewire.compras.compras.compras-form-component');
    }

    public function mount ($id, $tipo)
    {
        if ($id && $tipo)
        {
            $compra = Compra::findOrFail($id);

            $this->fill([
                'mode_edit' => true,
                'tipo' => $tipo,
                'id_compra' => $id,
                'numero' => $compra->numero,
                'fecha_compra' => $compra->fecha_compra,
                'fecha_entrega_oc' => $compra->fecha_entrega_oc,
                'fecha_entrega_mat' => $compra->fecha_entrega_mat,
                'id_cotizacion' => $compra->id_cotizacion,
                'num_resolucion_cu' => $compra->num_resolucion_cu,
                'fecha_resolucion_cu' => $compra->fecha_resolucion_cu,
                'nota1' => $compra->nota1,
                'id_forma_pago' => $compra->id_forma_pago,
                'id_punto_envio' => $compra->id_punto_envio,
                'id_adjudicante' => $compra->id_adjudicante,
                'nota2' => $compra->nota2,
                'req_rendicion' => $compra->req_rendicion,
                'id_tipo_adjudicacion' => $compra->id_tipo_adjudicacion,
                'num_procedimiento' => $compra->num_procedimiento,
                'fianza_anticipo' => $compra->fianza_anticipo,
                'fianza_fiel_comp' => $compra->fianza_fiel_comp,
                'porc_anticipo' => $compra->porc_anticipo,
                'numero_anticipo' => $compra->numero_anticipo,
                'tiempo_anticipo' => $compra->tiempo_anticipo,
                'estatus' => $compra->estatus
            ]);

       }
        else
        {
            $result = DB::table('compras.compras')
                ->select(DB::raw('count(*) as cont'))
                ->whereMonth('fecha_compra', '=', date('n'))
                ->where('tipo', '=', $tipo)
                ->get();
            $cont = $result[0]->cont + 1; //incrementas
            $mes = cambiarMes($this->fecha_compra);
            $num = sprintf("%'.05d", $cont); // formato con 5 digitos */

            $this->fill([
                'numero' => date("Y").$mes.$num,
                'fecha_actual' => Carbon::now()->format('Y-m-d'),
                'fecha_compra' => Carbon::now()->format('Y-m-d'),
                'req_rendicion' => $this->req_rendicion
            ]);

            $this->id_compra = -1;
            $this->mode_edit = false;
            $this->tipo = $tipo;
        }
    }

    public function updatedFechaCompra()
    {
        $result = DB::table('compras.compras')
        ->select(DB::raw('count(*) as cont'))
        ->whereMonth('fecha_compra', '=', Carbon::createFromFormat('Y-m-d', $this->fecha_compra)->format('n'))
        ->first();


        $cont = $result->cont + 1; //incrementas
        $mes = cambiarMes($this->fecha_compra);
        $num = sprintf("%'.05d", $cont); // formato con 5 digitos */

        $this->numero = Carbon::createFromFormat('Y-m-d', $this->fecha_compra)->format('Y').$mes.$num;
    }

    public function guardar ()
    {
        $this->user = Auth::user();

        if ($this->id_compra == -1)
        {
            Compra::create([
                'tipo' => $this->tipo,
                'numero' => $this->numero,
                'fecha_compra' => $this->fecha_compra,
                'fecha_entrega_oc' => $this->fecha_entrega_oc,
                'fecha_entrega_mat' => $this->fecha_entrega_mat,
                'id_cotizacion' => $this->id_cotizacion,
                'num_resolucion_cu' => $this->num_resolucion_cu,
                'fecha_resolucion_cu' => $this->fecha_resolucion_cu,
                'nota1' => $this->nota1,
                'id_forma_pago' => $this->id_forma_pago,
                'id_punto_envio' => $this->id_punto_envio,
                'id_adjudicante' => $this->id_adjudicante,
                'nota2' => $this->nota2,
                'req_rendicion' => $this->req_rendicion,
                'id_tipo_adjudicacion' => $this->id_tipo_adjudicacion,
                'num_procedimiento' => $this->num_procedimiento,
                'fianza_anticipo' => $this->fianza_anticipo,
                'fianza_fiel_comp' => $this->fianza_fiel_comp,
                'porc_anticipo' => $this->porc_anticipo,
                'numero_anticipo' => $this->numero_anticipo,
                'tiempo_anticipo' => $this->tiempo_anticipo,
                'user_id' => $this->user->id
            ]);
        } else{

            Compra::UpdateOrCreate(
                ['id' => $this->id_compra],
                [
                    'numero' => $this->numero,
                    'fecha_compra' => $this->fecha_compra,
                    'fecha_entrega_oc' => $this->fecha_entrega_oc,
                    'fecha_entrega_mat' => $this->fecha_entrega_mat,
                    'id_cotizacion' => $this->id_cotizacion,
                    'num_resolucion_cu' => $this->num_resolucion_cu,
                    'fecha_resolucion_cu' => $this->fecha_resolucion_cu,
                    'nota1' => $this->nota1,
                    'id_forma_pago' => $this->id_forma_pago,
                    'id_punto_envio' => $this->id_punto_envio,
                    'id_adjudicante' => $this->id_adjudicante,
                    'nota2' => $this->nota2,
                    'req_rendicion' => $this->req_rendicion,
                    'id_tipo_adjudicacion' => $this->id_tipo_adjudicacion,
                    'num_procedimiento' => $this->num_procedimiento,
                    'fianza_anticipo' => $this->fianza_anticipo,
                    'fianza_fiel_comp' => $this->fianza_fiel_comp,
                    'porc_anticipo' => $this->porc_anticipo,
                    'numero_anticipo' => $this->numero_anticipo,
                    'tiempo_anticipo' => $this->tiempo_anticipo,
                ]
            );
        }

        $mensaje = ($this->id_compra == -1 ? '[+] Compra Ingresada Correctamente.' : '[*] Compra Modificada Correctamente.');

        return redirect()->route('compras.index')->with('success', $mensaje);
    }
}
