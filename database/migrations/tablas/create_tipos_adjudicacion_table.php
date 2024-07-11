<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('global')->create('tipos_adjudicacion', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 100)->comment('Nombre del tipo de adjudicacion.');
            $table->timestamps();
        });

        DB::table('global.tipos_adjudicacion')->insert([
            [ 'id' => 1, 'descripcion' => 'ADJUDICACIÓN DIRECTA' ],
            [ 'id' => 2, 'descripcion' => 'CONCURSO ABIERTO' ],
            [ 'id' => 3, 'descripcion' => 'CONCURSO CERRADO' ],
            [ 'id' => 4, 'descripcion' => 'CONSULTA DE PRECIOS' ],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('global')->dropIfExists('tipos_adjudicacion');
    }
};
