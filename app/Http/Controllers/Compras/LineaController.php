<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LineaController extends Controller
{

    public function index()
    {
        return view('compras.lineas-index');
    }

    public function create()
    {
        //
        abort(404);
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

    public function edit($linea)
    {
        //
        abort(404);
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
