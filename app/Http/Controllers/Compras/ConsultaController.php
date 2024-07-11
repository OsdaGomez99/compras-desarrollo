<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\Planificacion\UnidadEjecutora;
use App\Models\Compras\Linea;
use App\Models\Global\UnidadMedida;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{

    public function selectSolicitante (Request $request)
    {
        $term = $request->get('term');
        $querys = UnidadEjecutora::where('descripcion', 'LIKE', '%' . $term . '%')->get();
        $data = [];

        foreach ($querys as $query)
        {
            $data[] = [
                'label' => $query->descripcion,
            ];
        }
        return $data;
    }

    public function selectLinea (Request $request)
    {
        $term = $request->get('term');
        $querys = Linea::where('descripcion', 'LIKE', '%' . $term . '%')->get();
        $data = [];

        foreach ($querys as $query)
        {
            $data[] = [
                'label' => $query->descripcion,
            ];
        }
        return $data;
    }

    public function selectMedida (Request $request)
    {
        $term = $request->get('term');
        $querys = UnidadMedida::where('descripcion', 'LIKE', '%' . $term . '%')->get();
        $data = [];

        foreach ($querys as $query)
        {
            $data[] = [
                'label' => $query->descripcion,
            ];
        }
        return $data;
    }

    public function selectArticulo (Request $request, $id)
    {
        $term = $request->get('term');
        $querys = Linea::with('articulos')
                                ->find($id)
                                ->where('id', $id)
                                ->orwhere('descripcion', 'LIKE', '%' . $term . '%')
                                ->first();
        $data = [];

        foreach ($querys->articulos as $articulo)
        {
            $data[] = [
                'label' => $articulo->descripcion,
            ];
        }
        return $data;
    }
}
