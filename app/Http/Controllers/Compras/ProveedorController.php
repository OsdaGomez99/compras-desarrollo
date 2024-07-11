<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        return view('compras.proveedores.index');
    }

    public function create()
    {
        return view('compras.proveedores.registro');
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
        return view('compras.proveedores.registro', ['id' => $id]);
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
