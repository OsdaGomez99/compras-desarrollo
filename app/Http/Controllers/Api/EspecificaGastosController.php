<?php

namespace App\Http\Controllers\Api;
use App\Models\Planificacion\especificadegasto as EspecificaGastos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EspecificaGastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $especificasGastos = EspecificaGastos::orderBy('id', 'ASC')->where('estatus', 1)
        ->get(['id','nivel','cod_ocepre','descripcion']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $especificaGasto = EspecificaGastos::where('id', $id)->where('estatus', 1)
        ->get(['id','nivel','cod_ocepre','descripcion']);
        return response()->json($especificaGasto);
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
