<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('compras')->create('modificaciones_compra', function (Blueprint $table) {
            $table->id()->comment('Identificador de modificación de compra.');
            $table->string('numero', 10)->unique()->comment('Número de solicitud de modificación de compra.');
            $table->date('fecha')->default(Carbon::now())->comment('Fecha de solicitud de modificación de compra.');
            $table->unsignedBigInteger('id_tipo_modificacion')->comment('Identificador de tipo de modificación.');
            $table->unsignedBigInteger('id_compra')->comment('Identificador de compra.');
            $table->string('nota', 200)->nullable()->comment('Justificación de la requisición de compra.');
            $table->date('fecha_ua')->default(Carbon::now())->comment('Fecha de ultima actualización.');
            $table->string('numero_ua', 5)->comment('Número de solicitud de ultima actualización.');
            $table->enum("tipo", ["BIENES", "SERVICIOS"])->comment('Tipo de modificacion.');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Identificador de usuario.');
            $table->timestamps();

            $table->foreign('id_tipo_modificacion')->references('id')->on('global.tipos_modificacion');
            $table->foreign('id_compra')->references('id')->on('compras.compras');
            $table->comment = 'Modificaciones/Cancelaciones de compras.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('modificaciones_compra');
    }
};
