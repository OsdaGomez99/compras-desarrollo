<?php

namespace App\Http\Controllers\Segurity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    //
    public function index()
    {
        return view('segurity.roles.index');
    }
}
