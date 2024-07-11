<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    Segurity\UsuariosAdminController,
    UsuarioController
};

use App\Http\Controllers\Segurity\{
    RolesController,
    PermisosController
};

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/principal', function () {
    return view('dashboard');
})->name('principal');

Route::get(
    '/reload_captcha',
    fn () => response()->json(['captcha' => captcha_img('flat')])
)->middleware('throttle:30');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/usuario/configuracion', fn () => view('users.actualizar-usuario'))
        ->name('user.configuracion');

    Route::post('/usuario/configuracion', [UsuarioController::class, 'actualizarUsuario'])
        ->name('user.configuracion');

});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'verified', 'role:admin']], function(){

    Route::get('/permisos', [PermisosController::class, 'index']);

    Route::get('/roles', [RolesController::class, 'index']);

    Route::resource('/usuarios', UsuariosAdminController::class)
        ->parameters([ 'usuario' => 'user:username' ])
        ->names('admin.user');
});



