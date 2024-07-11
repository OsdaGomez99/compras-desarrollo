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
        Schema::connection('compras')->create('compras', function (Blueprint $table) {
            $table->id()->comment('Identificador de orden de compra.');
            $table->string('numero', 10)->comment('Número de orden de compra.');
            $table->date('fecha_compra')->comment('Fecha de orden de compra.');
            $table->date('fecha_entrega_oc')->nullable()->comment('Fecha de entrega de orden de compra a proveedor.');
            $table->date('fecha_entrega_mat')->nullable()->comment('Fecha de entrega de materiales de orden de compra.');
            $table->date('fecha_resolucion_cu')->nullable()->comment('Fecha de resolución CU.');
            $table->string('num_resolucion_cu', 25)->nullable()->comment('Número de resolución CU.');
            $table->decimal('porc_iva', 6, 4)->nullable()->comment('Porcentaje de IVA.');
            $table->decimal('porc_ret_iva', 7, 4)->default(0)->comment('Porcentaje de retención de IVA.');
            $table->decimal('subtotal', 19, 4)->nullable()->comment('Subtotal de la orden de compra.');
            $table->decimal('monto_imput_iva', 19, 4)->nullable()->comment('Monto de imputación de IVA.');
            $table->decimal('total', 19, 4)->nullable()->comment('Total de la orden de compra.');
            $table->decimal('pago_neto', 19, 4)->nullable()->comment('Pago neto de la orden de compra.');
            $table->boolean('fianza_anticipo')->nullable()->default(false)->comment('Tiene fianza de anticipo (S/N).');
            $table->boolean('fianza_fiel_comp')->nullable()->default(false)->comment('Tiene fianza de fiel compromiso (S/N).');
            $table->integer('porc_anticipo')->nullable()->comment('Porcentaje de anticipo');
            $table->integer('numero_anticipo')->nullable()->comment('Cantidad de tiempo de anticipo');
            $table->enum('tiempo_anticipo', ['DIAS', 'MESES'])->nullable()->comment('Tipo de tiempo de anticipo');
            $table->boolean('req_rendicion')->default(false)->comment('Requiere rendición (S/N).');
            $table->string('num_procedimiento', 9)->nullable()->comment('Número de procedimiento.');
            $table->string('nota1', 200)->nullable()->comment('Nota de descripción.');
            $table->string('nota2', 200)->nullable()->comment('Nota de observación.');
            $table->unsignedBigInteger('id_cotizacion')->comment('Identificador de solicitud de cotización.');
            $table->unsignedBigInteger('id_proveedor')->nullable()->comment('Identificador de proveedor de cotización.');
            $table->unsignedSmallInteger('id_adjudicante')->default(1)->comment('Adjudicante');
            $table->unsignedSmallInteger('id_tipo_adjudicacion')->default(1)->comment('Tipo de adjudicación.');
            $table->unsignedSmallInteger('id_forma_pago')->default(1)->comment('Identificador de forma de pago.');
            $table->unsignedSmallInteger('id_punto_envio')->default(1)->comment('Identificador de punto de envío.');
            $table->enum('estatus', [
                'TRANSCRITA',
                'APROBADA COMPRAS',
                'APROBADA PRESUP.',
                'APROBADA',
                'RECHAZADA PRESUP.',
                'CERRADA',
                'ANULADA',
                'ELIMINADA'
            ])->default('TRANSCRITA')->comment('Tipo de requisición.');
            $table->enum("tipo", ["BIENES", "SERVICIOS"])->comment('Tipo de solicitud.');
            $table->unsignedBigInteger('user_id')->comment('Identificador de usuario.');
            $table->timestamps();

            $table->foreign('id_punto_envio')->references('id')->on('global.puntos_envio');
            $table->foreign('id_forma_pago')->references('id')->on('global.formas_pago');
            $table->foreign('id_adjudicante')->references('id')->on('global.adjudicantes');
            $table->foreign('id_tipo_adjudicacion')->references('id')->on('global.tipos_adjudicacion');
            $table->foreign('user_id')->references('id')->on('segurity.users');
            $table->unique(['numero','tipo']);
            $table->comment = 'Ordenes de compra.';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('compras')->dropIfExists('compras');
    }
};
