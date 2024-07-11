<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planificacion\CentroCosto;
class CentroCostosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centros = CentroCosto::orderBy('id', 'ASC')
            ->with('unidad')
            ->with('ubicacion')
            ->with('ambito')
            ->with('apertura')
            ->with('especificaGasto')
            ->get();
        return response()->json($centros);
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
        $centro = CentroCosto::where('id', $id)
            ->with('unidad')
            ->with('ubicacion')
            ->with('ambito')
            ->with('apertura')
            ->with('especificaGasto')
            ->get();
        return response()->json($centro);
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
