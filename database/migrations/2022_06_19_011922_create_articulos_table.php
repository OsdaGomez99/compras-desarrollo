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
        Schema::connection('compras')->create('articulos', function (Blueprint $table) {
            $table->id()->comment('Identificador de artículo.');
            $table->string('descripcion', 250)->comment('Descripción de artículo.');
            $table->decimal('ultimo_precio', 19, 4)->nullable()->comment('Precio del artículo según órdenes de compra.');
            $table->unsignedInteger('id_linea')->nullable()->comment('Identificador de línea.');
            $table->unsignedInteger('id_unidad_medida')->nullable()->comment('Identificador de unidad de medida.');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Identificador de usuario.');
            $table->string('cod_art_ccce', 9)->nullable()->comment('cod_articulo_ccce');
            $table->string('cod_ocepre', 12)->nullable()->comment('cod_ocepre');
            $table->string('cod_cnu', 8)->nullable()->comment('cod_cnu');
            $table->boolean('status')->default(true)->comment('Status de artículo');
            $table->timestamps();

            $table->foreign('id_linea')->references('id')->on('compras.lineas');
            $table->foreign('id_unidad_medida')->references('id')->on('global.unidades_medida');
            $table->foreign('user_id')->references('id')->on('segurity.users');
            $table->unique(['descripcion','id_linea','id_unidad_medida']);
            $table->comment = 'Artículos.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('articulos');
    }

    /*
    CREATE TABLE compras.articulos (
	id bigserial NOT NULL,
	descripcion text NOT NULL,
	ultimo_precio numeric(19,4) NULL,
	id_linea_suministro int4 NULL,
	id_unidad_medida int4 NULL,
	id_status int2 NULL,
	user_id int8 NULL,
	stock bool NULL,
	cod_art_ccce varchar(9) NULL,
	cod_ocepre varchar(12) NULL,
	cod_cnu varchar(8) NULL,
	created_at timestamp NULL,
	updated_at timestamp NULL,
	status bool NULL DEFAULT true,
	CONSTRAINT articulos_pkey PRIMARY KEY (id),
	CONSTRAINT articulos_id_linea_suministro_foreign FOREIGN KEY (id_linea_suministro) REFERENCES compras.lineas_suministro(id),
	CONSTRAINT articulos_id_unidad_medida_foreign FOREIGN KEY (id_unidad_medida) REFERENCES global.unidades_medida(id),
	CONSTRAINT articulos_user_id_foreign FOREIGN KEY (user_id) REFERENCES segurity.users(id)
);

    */
};
