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
        Schema::connection('global')->create('adjudicantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->comment('Nombre del adjudicante');
            $table->timestamps();
        });

        DB::table('global.adjudicantes')->insert([
            [ 'id' => 1, 'nombre' => 'CONSEJO ADMIN.' ],
            [ 'id' => 2, 'nombre' => 'VICE. RECTOR. ADMIN.' ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('global')->dropIfExists('adjudicantes');
    }
};
