<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Oferta;

class DetalleOfertaController extends Controller
{
    public function show($id)
    {
        $oferta = Oferta::with('proveedor')->where('id', $id)->first();
        return view('compras.ofertas.detalle', ['oferta' => $oferta]);
    }
}
