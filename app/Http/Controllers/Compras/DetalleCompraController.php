<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Compra;

class DetalleCompraController extends Controller
{
    public function show($id)
    {
        $compra = Compra::where('id', $id)->first();
        return view('compras.compras.detalle', ['compra' => $compra]);
    }
}
