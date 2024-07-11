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
        Schema::connection('compras')->create('detalles_modificacion', function (Blueprint $table) {
            $table->id()->comment('Identificador de detalle de modificación de compra.');
            $table->unsignedBigInteger('id_modificacion')->comment('Identificador de modificación de compra.');
            $table->unsignedBigInteger('id_detalle_compra')->comment('Identificador de detalle de compra.');
            $table->decimal('cantidad_modif')->comment('Cantidad modificada.');
            $table->decimal('precio_modif', 19, 4)->comment('Precio modificada.');
            $table->timestamps();

            $table->foreign('id_modificacion')->references('id')->on('compras.modificaciones_compra');
            $table->foreign('id_detalle_compra')->references('id')->on('compras.detalles_compra');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('detalle_modificaciones');
    }
};
