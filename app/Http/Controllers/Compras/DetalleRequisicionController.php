<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Requisicion;

class DetalleRequisicionController extends Controller
{

    public function show($id)
    {
        $requisicion = Requisicion::where('id', $id)->first();
        return view('compras.requisiciones.detalle', ['requisicion' => $requisicion]);
    }

}
