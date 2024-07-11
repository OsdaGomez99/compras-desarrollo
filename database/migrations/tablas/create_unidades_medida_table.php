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
        Schema::connection('global')->create('unidades_medida', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->comment('Nombre de la unidad de medida.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('global')->dropIfExists('unidades_medida');
    }
};
