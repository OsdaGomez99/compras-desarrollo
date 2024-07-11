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
        Schema::connection('compras')->create('cotizaciones', function (Blueprint $table) {
            $table->id()->comment('Identificador de solicitud de cotización.');
            $table->string('numero', 10)->comment('Número de solicitud de cotización.');
            $table->date('fecha_cotizacion')->comment('Fecha de solicitud de cotización.');
            $table->date('fecha_vigencia')->default(Carbon::now())->comment('Fecha de vencimiento de la solicitud.');
            $table->date('fecha_tope')->default(Carbon::now())->nullable()->comment('Fecha tope de la solicitud.');
            $table->time('hora_tope')->nullable()->comment('Hora tope de la solicitud.');
            $table->date('fecha_visita')->default(Carbon::now())->nullable()->comment('Fecha de visita tecnica de la solicitud.');
            $table->time('hora_visita')->nullable()->comment('Hora de visita tecnica de la solicitud.');
            $table->string('lugar_visita', 200)->nullable()->comment('Lugar de visita tecnica de la solicitud.');
            $table->enum('estatus',[
                'TRANSCRITA',
                'COTIZACION ENVIADA',
                'OFERTAS RECIBIDAS',
                'CERRADA',
                'ANULADA',
                'ELIMINADA'
            ])->default('TRANSCRITA')->comment('Estatus de la solicitud.');
            $table->enum("tipo", ["BIENES", "SERVICIOS"])->comment('Tipo de solicitud.');
            $table->unsignedBigInteger('user_id')->comment('Identificador de usuario.');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('segurity.users');
            $table->unique(['numero','tipo']);
            $table->comment = 'Solicitudes de cotización.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('cotizaciones');
    }
};
