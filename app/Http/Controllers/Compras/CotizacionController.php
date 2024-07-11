<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{

    public function index()
    {
        return view('compras.cotizaciones.index');
    }

    public function create()
    {
        return view('compras.cotizaciones.registro');
    }

    public function crear($tipo)
    {
        return view('compras.cotizaciones.registro', ['tipo' => $tipo]);
    }

    public function editar($tipo, $id)
    {
        return view('compras.cotizaciones.registro', ['tipo' => $tipo, 'id' => $id]);
    }

    public function store(Request $request)
    {
        //
        abort(404);
    }

    public function show($id)
    {
        //
        abort(404);
    }

    public function edit($id)
    {
        return view('compras.cotizaciones.registro', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        //
        abort(404);
    }

    public function destroy($id)
    {
        //
        abort(404);
    }

}
