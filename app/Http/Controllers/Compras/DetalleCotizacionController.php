<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Cotizacion;

class DetalleCotizacionController extends Controller
{
    public function show($id)
    {
        $cotizacion = Cotizacion::where('id', $id)->first();
        return view('compras.cotizaciones.detalle', ['cotizacion' => $cotizacion]);
    }
}
