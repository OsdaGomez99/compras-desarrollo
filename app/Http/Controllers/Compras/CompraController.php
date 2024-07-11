<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Compra;
use App\Models\Compras\DetalleCompra;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;

class CompraController extends Controller
{
    public function __construct()
    {
        $this->pdf = App::make('dompdf.wrapper');
    }

    public function index()
    {
        return view('compras.compras.index');
    }

    public function create()
    {
       //
       abort(404);
    }

    public function crear($tipo)
    {
        return view('compras.compras.registro', ['tipo' => $tipo]);
    }

    public function editar($tipo, $id)
    {
        return view('compras.compras.registro', ['tipo' => $tipo, 'id' => $id]);
    }

    public function show($id)
    {
        //
        abort(404);
    }

    public function edit($id)
    {
        return view('compras.compras.registro', ['id' => $id]);
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
        $compra = Compra::find($id);
        $detalles = DetalleCompra::where('id_compra', $id)->get();
        $this->pdf = PDF::loadView('compras.compras.imprimir', compact('compra', 'detalles'));
        return $this->pdf->stream('OC.pdf');
    }

    public function imprimir_vista($id)
    {
        $compra = Compra::find($id);
        $detalles = DetalleCompra::where('id_compra', $id)->get();
        return view('compras.imprimir_vista', compact('compra', 'detalles'));
        return $this->pdf->stream('ORDEN DE COMPRA DE '.$compra->tipo.' NRO. '.$compra->numero. '.pdf');

    }
}
