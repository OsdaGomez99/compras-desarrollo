<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Compras\{
    RequisicionController,
    DetalleRequisicionController,
    CotizacionController,
    DetalleCotizacionController,
    OfertaController,
    DetalleOfertaController,
    CompraController,
    DetalleCompraController,
    ArticuloController,
    ProveedorController,
    LineaController,
    EvaluacionProvController,
    ModificacionesCompraController,
};

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::resource('/requisiciones', RequisicionController::class);
    Route::resource('/detalle_requisicion', DetalleRequisicionController::class);
    Route::resource('/cotizaciones', CotizacionController::class);
    Route::resource('/detalle_cotizacion', DetalleCotizacionController::class);
    Route::resource('/ofertas', OfertaController::class);
    Route::resource('/detalle_oferta', DetalleOfertaController::class);
    Route::resource('/compras', CompraController::class);
    Route::resource('/detalle_compra', DetalleCompraController::class);
    Route::resource('/articulos', ArticuloController::class);
    Route::resource('/proveedores', ProveedorController::class);
    Route::resource('/lineas', LineaController::class);
    Route::resource('/evaluacionesprov', EvaluacionProvController::class);
    Route::resource('/modificaciones', ModificacionesCompraController::class);

    Route::get('/requisiciones/crear/{tipo}', [RequisicionController::class, 'crear'])->name('requisiciones.crear');
    Route::get('/requisiciones/editar/{tipo}/{id}', [RequisicionController::class, 'editar'])->name('requisiciones.editar');
    Route::get('/cotizaciones/crear/{tipo}', [CotizacionController::class, 'crear'])->name('cotizaciones.crear');
    Route::get('/cotizaciones/editar/{tipo}/{id}', [CotizacionController::class, 'editar'])->name('cotizaciones.editar');
    Route::get('/ofertas/editar/{tipo}/{id}', [OfertaController::class, 'editar'])->name('ofertas.editar');
    Route::get('/compras/crear/{tipo}', [CompraController::class, 'crear'])->name('compras.crear');
    Route::get('/compras/editar/{tipo}/{id}', [CompraController::class, 'editar'])->name('compras.editar');

    Route::get('/requisiciones/imprimir/{id}', [RequisicionController::class, 'imprimir'])->name('requisiciones.imprimir');
    Route::get('/ofertas/imprimir/{id}', [OfertaController::class, 'imprimir'])->name('ofertas.imprimir');
    Route::get('/compras/imprimir/{id}', [CompraController::class, 'imprimir'])->name('compras.imprimir');


});


Route::get('/compras/imprimir_vista/{id}', [CompraController::class, 'imprimir_vista'])->name('compras.imprimir_vista');
