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
        Schema::connection('global')->create('tipos_persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100)->comment('Nombre del tipo de persona');
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
        Schema::connection('global')->dropIfExists('tipos_persona');
    }
};
