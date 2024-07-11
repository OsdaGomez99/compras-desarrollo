<?php

namespace App\Http\Controllers\Segurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    //
    public function index()
    {
        return view('segurity.permisos.index');
    }
}
