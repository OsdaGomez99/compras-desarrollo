<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Planificacion\CentroCosto;
use App\Models\Planificacion\EspecificaIngresos;
use App\Models\Planificacion\especificadegasto as EspecificaGastos;
use App\Models\Planificacion\Ubicaciones;
use App\Models\Planificacion\UnidadEjecutora;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CentroCostos()
    {
        $centros = CentroCosto::orderBy('id', 'ASC')
            ->with('unidad')
            ->with('ubicacion')
            ->with('ambito')
            ->with('apertura')
            ->with('especificaGasto')
            ->paginate(1000);
        return response()->json($centros);
    }
    public function Ubicaciones()
    {
        $ubicaciones = Ubicaciones::orderBy('id', 'ASC')->where('estatus', 1)
            ->get();
        return response()->json($ubicaciones);
    }
    public function UnidadesEjecutoras()
    {
        $unidades = UnidadEjecutora::orderBy('id', 'ASC')->where('estatus', 1)
            ->get();
        return response()->json($unidades);
    }
    public function EspecificasIngresos()
    {
        $especificaIngresos = EspecificaIngresos::orderBy('id', 'ASC')->where('status', 1)
            ->get();
        return response()->json($especificaIngresos);
    }
    public function EspecificaGastos()
    {
        $especificasGastos = EspecificaGastos::orderBy('id', 'ASC')->where('estatus', 1)
            ->get();
        return response()->json($especificasGastos);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CentroCosto  $centroCosto
     * @return \Illuminate\Http\Response
     */
    public function show(CentroCosto $centroCosto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CentroCosto  $centroCosto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CentroCosto $centroCosto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CentroCosto  $centroCosto
     * @return \Illuminate\Http\Response
     */
    public function destroy(CentroCosto $centroCosto)
    {
        //
    }
}
