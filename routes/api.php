<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    CentroCostosController as CentroCosto,
    EspecificaGastosController as EspecificaGastos,
    EspecificaIngresosController as EspecificaIngresos,
    UbicacionesController as Ubicaciones,
    UnidadesEjecutorasController as UnidadesEjecutoras,
    AperturasProgramaticasController as AperturaProgramaticas,
    AmbitoProyectoController as AmbitoProyecto,
    PresupuestoController   as Presupuesto

};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/planificacion/centros-costos', CentroCosto::class)
->only(['index','show']);

Route::apiResource('/planificacion/especificas-gastos', EspecificaGastos::class)
->only(['index','show']);

Route::apiResource('/planificacion/especificas-ingresos', EspecificaIngresos::class)
->only(['index','show']);

Route::apiResource('/planificacion/ubicaciones', Ubicaciones::class)
->only(['index','show']);

Route::apiResource('/planificacion/unidades-ejecutoras', UnidadesEjecutoras::class)
->only(['index','show']);

Route::apiResource('/planificacion/aperturas-programaticas', AperturaProgramaticas::class)
->only(['index','show']);

Route::apiResource('/planificacion/ambitos-proyectos', AmbitoProyecto::class)
->only(['index','show']);


Route::apiResource('/presupuesto/disponible', Presupuesto::class)
->only(['index','show']);