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
        Schema::connection('compras')->create('detalles_oferta', function (Blueprint $table) {
            $table->id()->comment('Identificador de detalle de oferta de proveedor.');
            $table->unsignedBigInteger('id_oferta')->comment('Identificador de oferta de proveedor.');
            $table->unsignedBigInteger('id_detalle_requisicion')->comment('Identificador de detalle de requisición de compra.');
            $table->unsignedInteger('cantidad_cotizada')->comment('Cantidad cotizada.');
            $table->unsignedInteger('cantidad_ofertada')->nullable()->comment('Cantidad ofertada.');
            $table->decimal('precio', 19, 4)->nullable()->comment('Precio del artículo.');
            $table->boolean('exento_iva')->default('false')->nullable()->comment('Exento de IVA');
            $table->timestamps();

            $table->foreign('id_oferta')->references('id')->on('compras.ofertas');
            $table->foreign('id_detalle_requisicion')->references('id')->on('compras.detalles_requisicion');
            $table->comment = 'Detalle de ofertas de proveedores.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('detalles_oferta');
    }
};
