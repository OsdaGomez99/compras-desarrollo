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
        Schema::connection('compras')->create('proveedores', function (Blueprint $table) {
            $table->id()->comment('Identificador de proveedor.');
            $table->string('nombre', 150)->unique()->comment('Nombre del proveedor.');
            $table->string('rif', 12)->unique()->comment('Número de Registro de Información Fiscal.');
            $table->string('representante', 40)->nullable()->comment('Nombre del representante legal.');
            $table->string('telefono', 12)->nullable()->comment('Teléfono.');
            $table->string('telefono_alt', 12)->nullable()->comment('Teléfono alternativo.');
            $table->string('email', 40)->nullable()->comment('Dirección de correo electrónico.');
            $table->string('direccion', 200)->nullable()->comment('Dirección fiscal.');
            $table->string('num_rnc', 20)->nullable()->comment('');
            $table->string('nro_alsobocaroni', 30)->nullable()->comment('');
            $table->string('cod_grupo_alsobocaroni', 4)->nullable()->comment('');
            $table->string('ruc_alsobocaroni', 8)->nullable()->comment('');
            $table->boolean('status')->default(true)->comment('Indica si el proveedor está activo.');
            $table->unsignedInteger('id_tipo_persona')->nullable()->comment('Identificador de tipo de persona.');
            $table->unsignedInteger('id_tipo_empresa')->nullable()->comment('Identificador de tipo de empresa.');
            $table->unsignedBigInteger('user_id')->comment('Identificador de usuario.');
            $table->timestamps();

            $table->foreign('id_tipo_persona')->references('id')->on('global.tipos_persona');
            $table->foreign('id_tipo_empresa')->references('id')->on('global.tipos_empresa');
            $table->foreign('user_id')->references('id')->on('segurity.users');
            $table->comment = 'Proveedores.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('proveedores');
    }

    /*
    CREATE TABLE compras.proveedores (
	id bigserial NOT NULL,
	nombre varchar(150) NOT NULL,
	rif varchar(12) NOT NULL,
	representante varchar(40) NULL,
	telefono varchar(12) NULL,
	telefono_alt varchar(12) NULL,
	email varchar(40) NULL,
	direccion text NULL,
	num_rnc varchar(20) NULL,
	nro_alsobocaroni varchar(30) NULL,
	cod_grupo_alsobocaroni varchar(4) NULL,
	ruc_alsobocaroni varchar(8) NULL,
	id_cuenta_contable int4 NULL,
	id_tipo_persona int4 NULL,
	id_tipo_empresa int4 NULL,
	id_status int4 NOT NULL,
	user_id int8 NOT NULL,
	created_at timestamp NULL,
	updated_at timestamp NULL,
	CONSTRAINT proveedores_nombre_unique UNIQUE (nombre),
	CONSTRAINT proveedores_pkey PRIMARY KEY (id),
	CONSTRAINT proveedores_rif_unique UNIQUE (rif),
	CONSTRAINT proveedores_id_status_foreign FOREIGN KEY (id_status) REFERENCES global.status(id),
	CONSTRAINT proveedores_id_tipo_empresa_foreign FOREIGN KEY (id_tipo_empresa) REFERENCES global.tipos_empresa(id),
	CONSTRAINT proveedores_id_tipo_persona_foreign FOREIGN KEY (id_tipo_persona) REFERENCES global.tipos_persona(id),
	CONSTRAINT proveedores_user_id_foreign FOREIGN KEY (user_id) REFERENCES segurity.users(id)
);
    */
};
