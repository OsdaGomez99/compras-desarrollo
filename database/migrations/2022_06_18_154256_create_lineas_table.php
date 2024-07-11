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
        Schema::connection('compras')->create('lineas', function (Blueprint $table) {
            $table->id()->comment('Identificador de línea.');
            $table->string('descripcion', 80)->comment('Descripción de línea.');
            $table->boolean('status')->default(true)->comment('Indica si la línea está activa.');
            $table->enum('tipo', [
                'BIENES',
                'SERVICIOS'
            ])->comment('Tipo de linea.');
            $table->timestamps();

            $table->unique(['descripcion','tipo']);
            $table->comment = 'Líneas de suministro y de servicios.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('lineas');
    }

    /*
    CREATE TABLE compras.lineas_suministro (
	id bigserial NOT NULL,
	descripcion varchar(80) NOT NULL,
	created_at timestamp NULL,
	updated_at timestamp NULL,
	id_tipo int2 NULL,
	status bool NULL DEFAULT true,
	CONSTRAINT lineas_suministro_descripcion_unique UNIQUE (descripcion),
	CONSTRAINT lineas_suministro_id_tipo_check CHECK (((id_tipo = 1) OR (id_tipo = 2))),
	CONSTRAINT lineas_suministro_pkey PRIMARY KEY (id)
);*/

};
