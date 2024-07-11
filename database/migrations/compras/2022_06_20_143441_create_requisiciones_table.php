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
        Schema::connection('compras')->create('requisiciones', function (Blueprint $table) {
            $table->id()->comment('Identificador de requisición de compra.');
            $table->string('numero', 10)->comment('Número de requisición de compra.');
            $table->date('fecha_requisicion')->comment('Fecha de requisición de compra.');
            $table->date('fecha_recepcion')->nullable()->comment('Fecha de recepcion de requisición de compra.');
            $table->integer('trimestre')->nullable()->comment('Trimestre de la requisicion.');
            $table->integer('num_referencia')->nullable()->comment('Número de referencia.');
            $table->string('justificacion', 500)->nullable()->comment('Justificación de la requisición de compra.');
            $table->enum('estatus', [
                'TRANSCRITA',
                'APROBADA',
                'CERRADA',
                'ANULADA',
                'ELIMINADA'
            ])->default('TRANSCRITA')->comment('Tipo de requisición.');
            $table->enum("tipo", ["BIENES", "SERVICIOS"])->comment('Tipo de solicitud.');
            $table->unsignedSmallInteger('id_anno')->comment('Identificador de año presupuestario');
            $table->unsignedSmallInteger('id_solicitante')->comment('Identificador de unidad solicitante.');
            $table->unsignedSmallInteger('id_linea')->comment('Identificador de linea.');
            $table->unsignedSmallInteger('id_prioridad')->default(1)->comment('Identificador de prioridad de compra.');
            $table->unsignedBigInteger('user_id')->comment('Identificador de usuario.');
            $table->timestamps();

            $table->foreign('id_anno')->references('id')->on('planificacion.annos_fiscales');
            $table->foreign('id_solicitante')->references('id')->on('planificacion.unidades_ejecutoras');
            $table->foreign('id_linea')->references('id')->on('compras.lineas');
            $table->foreign('id_prioridad')->references('id')->on('global.prioridades');
            $table->foreign('user_id')->references('id')->on('segurity.users');
            $table->unique(['numero','tipo']);
            $table->comment = 'Requisiciones de compras.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('requisiciones');
    }

/* -- Drop table

-- DROP TABLE compras.requisiciones;

CREATE TABLE compras.requisiciones (
	id bigserial NOT NULL,
	id_sistema_compras int2 NULL,
	id_solicitante int8 NOT NULL,
	id_prioridad int2 NULL DEFAULT 1::smallint,
	user_id int8 NULL,
	numero varchar(10) NOT NULL,
	fecha_requisicion date NOT NULL DEFAULT '2022-06-28'::date,
	justificacion text NULL,
	created_at timestamp NULL,
	updated_at timestamp NULL,
	anno_ppto int4 NULL,
	id_centro_costo int8 NULL,
	id_linea_suministro int8 NULL,
	id_status int2 NULL,
	trimestre int4 NULL,
	num_referencia int4 NULL,
	fecha_recepcion date NULL,
	CONSTRAINT requisiciones_num_requisicion_unique UNIQUE (numero),
	CONSTRAINT requisiciones_pkey PRIMARY KEY (id),
	CONSTRAINT requisiciones_id_linea_suministro_foreign FOREIGN KEY (id) REFERENCES compras.lineas_suministro(id),
	CONSTRAINT requisiciones_id_prioridad_foreign FOREIGN KEY (id_prioridad) REFERENCES global.prioridades(id),
	CONSTRAINT requisiciones_id_sistema_compras_foreign FOREIGN KEY (id_sistema_compras) REFERENCES compras.sistemas_compras(id),
	CONSTRAINT requisiciones_id_solicitante_foreign FOREIGN KEY (id_solicitante) REFERENCES planificacion.unidades_ejecutoras(id),
	CONSTRAINT requisiciones_id_status_foreign FOREIGN KEY (id_status) REFERENCES global.status(id),
	CONSTRAINT requisiciones_user_id_foreign FOREIGN KEY (user_id) REFERENCES segurity.users(id)
); */

};
