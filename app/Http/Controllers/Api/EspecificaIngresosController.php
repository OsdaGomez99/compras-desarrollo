<?php

namespace App\Http\Controllers\Api;
use App\Models\Planificacion\EspecificaIngresos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspecificaIngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especificaIngresos = EspecificaIngresos::orderBy('id', 'ASC')->where('status', 1)
        ->get(['id','nivel','codigo','descripcion']);
        return response()->json($especificaIngresos);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $especificaIngreso = EspecificaIngresos::where('id', $id)->where('status', 1)
        ->get(['id','nivel','codigo','descripcion']);
        return response()->json($especificaIngreso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
