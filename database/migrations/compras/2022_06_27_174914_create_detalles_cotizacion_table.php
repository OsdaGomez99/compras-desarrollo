<?php

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
        Schema::connection('compras')->create('detalles_cotizacion', function (Blueprint $table) {
            $table->id()->comment('Identificador de detalle de solicitud de cotización.');
            $table->unsignedBigInteger('id_cotizacion')->comment('Identificador de solicitud de cotización.');
            $table->unsignedBigInteger('id_detalle_requisicion')->comment('Identificador de detalle de requisición de compra.');
            $table->unsignedInteger('cantidad')->default(1)->comment('Cantidad cotizada.');
            $table->timestamps();

            $table->foreign('id_cotizacion')->references('id')->on('compras.cotizaciones');
            $table->foreign('id_detalle_requisicion')->references('id')->on('compras.detalles_requisicion');
            $table->comment = 'Detalle de solicitudes de cotización.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('detalles_cotizacion');
    }
};
