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
        Schema::connection('compras')->create('detalles_requisicion', function (Blueprint $table) {
            $table->id()->comment('Identificador de detalle de requisición de compra.');
            $table->unsignedBigInteger('id_requisicion')->comment('Identificador de requisición de compra.');
            $table->unsignedBigInteger('id_articulo')->nullable()->comment('Identificador de artículo.');
            $table->string('descripcion', 300)->nullable()->comment('Descripcion de la requisición de compra de servicios');
            $table->unsignedInteger('id_unidad_medida')->nullable()->comment('Identificador de unidad de medida.');
            $table->unsignedInteger('cantidad')->default(1)->comment('Cantidad requerida.');
            $table->timestamps();

            $table->foreign('id_requisicion')->references('id')->on('compras.requisiciones');
            $table->foreign('id_articulo')->references('id')->on('compras.articulos');
            $table->foreign('id_unidad_medida')->references('id')->on('global.unidades_medida');
            $table->comment = 'Detalle de requisiciones de compras.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('detalles_requisicion');
    }
};
