<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compras\Requisicion;
use App\Models\Compras\DetalleRequisicion;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\App;


class RequisicionController extends Controller
{
    public function __construct()
    {
        $this->pdf = App::make('dompdf.wrapper');
    }

    public function index()
    {
        return view('compras.requisiciones.index');
    }

    public function create()
    {
        //
        abort(404);
    }

    public function crear($tipo)
    {
        return view('compras.requisiciones.registro', ['tipo' => $tipo]);
    }

    public function editar($tipo, $id)
    {
        return view('compras.requisiciones.registro', ['tipo' => $tipo, 'id' => $id]);
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

    public function createPDF($id)
    {
        $this->usuario = Auth::user();
        $this->id_almacenista = Personal::where('cedula', '=', $this->usuario->cedula)->first();
        $this->recepcion = Movimiento::find($id);
        $this->detalles = DetalleMovimiento::where('id_movimiento', '=', $id)->get();
        if ($this->recepcion->id_tipo_documento == 2) {
            $this->compra = OrdenCompra::where('id', '=', $this->detalles[0]->id_documento_ref)->first();
            $data = [

                'recepcion' => $this->recepcion,
                'detalles' => $this->detalles,
                'compra' => $this->compra,
                'responsable' =>  $this->id_almacenista

            ];
        } else {
            $data = [

                'recepcion' => $this->recepcion,
                'detalles' => $this->detalles,
                'responsable' =>  $this->id_almacenista

            ];
        }

        $this->pdf->loadView('compras.pdf', $data);

        return $this->pdf->download('Requisicion.pdf');
    }

    public function imprimir($id)
    {
        $requisicion = Requisicion::find($id);
        $detalles = DetalleRequisicion::where('id_requisicion', $id)->get();
        $this->pdf = PDF::loadView('compras.requisiciones.imprimir', compact('requisicion', 'detalles'));
        return $this->pdf->stream('REQ. DE '.$requisicion->tipo.' NRO. '.$requisicion->numero. '.pdf');
    }

}
