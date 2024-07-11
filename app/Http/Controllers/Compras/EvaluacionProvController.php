<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EvaluacionProvController extends Controller
{
    public function index()
    {
        return view('compras.evaluacionesprov.index');
    }

    public function create()
    {
        return view('compras.evaluacionesprov.registro');
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

    public function edit($evaluacion)
    {
        return view('compras.evaluacionesprov.registro', ['evaluacion' => $evaluacion]);
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
