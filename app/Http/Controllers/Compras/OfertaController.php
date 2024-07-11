<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Oferta;
use App\Models\Compras\DetalleOferta;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;

class OfertaController extends Controller
{
    public function __construct()
    {
        $this->pdf = App::make('dompdf.wrapper');
    }

    public function index()
    {
        return view('compras.ofertas.index');
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

    public function editar($tipo, $id)
    {
        return view('compras.ofertas.registro', ['tipo' => $tipo, 'id' => $id]);
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

    public function imprimir($id)
    {
        $oferta = Oferta::find($id);
        $detalles = DetalleOferta::where('id_oferta', $id)->get();
        $this->pdf = PDF::loadView('compras.ofertas.imprimir', compact('oferta', 'detalles'));
        return $this->pdf->stream('OFERTA PARA PROVEEDOR '.$oferta->proveedor->nombre.' - COT. DE '.$oferta->tipo.' NRO. '.$oferta->cotizacion->numero.'.pdf');
    }

    public function imprimir_vista ($id)
    {
        $oferta = Oferta::find($id);
        $detalles = DetalleOferta::where('id_oferta', $id)->get();
        return view ('compras.imprimir_vista', compact('oferta', 'detalles'));
    }


}
