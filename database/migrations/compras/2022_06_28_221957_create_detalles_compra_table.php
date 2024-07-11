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
        Schema::connection('compras')->create('detalles_compra', function (Blueprint $table) {
            $table->id()->comment('Identificador de detalle de orden de compra.');
            $table->unsignedBigInteger('id_compra')->comment('Identificador de orden de compra.');
            $table->unsignedBigInteger('id_detalle_oferta')->comment('Identificador de detalle de oferta para compra.');
            $table->unsignedBigInteger('id_centro_costo')->comment('Identificador de centro de costo para cada detalle');
            $table->timestamps();

            $table->foreign('id_compra')->references('id')->on('compras.compras');
            $table->foreign('id_detalle_oferta')->references('id')->on('compras.detalles_oferta');
            $table->foreign('id_centro_costo')->references('id')->on('planificacion.planes_detalles');
            $table->comment = 'Detalle de órdenes de compra.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('detalles_compra');
    }
};
