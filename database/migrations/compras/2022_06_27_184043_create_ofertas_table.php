<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('compras')->create('ofertas', function (Blueprint $table) {
            $table->id()->comment('Identificador de oferta de proveedor.');
            $table->unsignedBigInteger('id_cotizacion')->comment('Identificador de solicitud de cotización.');
            $table->unsignedBigInteger('id_proveedor')->comment('Identificador de proveedor de la oferta.');
            $table->date('fecha_entrega')->nullable()->comment('Fecha de la entrega.');
            $table->date('fecha_recepcion')->nullable()->comment('Fecha de recepcion.');
            $table->date('fecha_oferta')->default(Carbon::now())->nullable()->comment('Fecha de la oferta.');
            $table->date('fecha_vigencia')->default(Carbon::now())->nullable()->comment('Fecha de vencimiento de la oferta.');
            $table->string('condiciones_venta', 1500)->nullable()->comment('Condiciones de venta.');
            $table->decimal('descuento', 4, 2)->nullable()->comment('Porcentaje de descuento.');
            $table->decimal('van', 4, 2)->nullable()->comment('Porcentaje de ...');
            $table->enum("tipo", ["BIENES", "SERVICIOS"])->comment('Tipo de solicitud.');
            $table->enum('estatus',[
                'TRANSCRITA',
                'COTIZACION ENVIADA',
                'OFERTAS RECIBIDAS',
                'ACEPTADA'
            ])->default('TRANSCRITA')->comment('Estatus de la solicitud.');
            $table->timestamps();

            $table->unique(['id_cotizacion', 'id_proveedor']);
            $table->foreign('id_cotizacion')->references('id')->on('compras.cotizaciones');
            $table->foreign('id_proveedor')->references('id')->on('compras.proveedores');
            $table->comment = 'Ofertas de proveedores.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('ofertas');
    }
};
