<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Polizas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id');
            $table->integer('compania_id');
            $table->integer('codigo_productor_id');
            $table->integer('tipo_riesgo_id');
            $table->integer('numero_solicitud');
            $table->string('numero')->nullable();
            $table->integer('estado_poliza_id')->nullable();
            $table->string('renueva_numero')->nullable();
            $table->integer('tipo_vigencia_id')->nullable();
            $table->integer('vigencia_dias')->nullable();
            $table->string('vigencia_desde')->nullable();
            $table->string('vigencia_hasta')->nullable();
            $table->string('fecha_solicitud')->nullable();
            $table->string('fecha_emision')->nullable();
            $table->string('fecha_recepcion')->nullable();
            $table->string('fecha_entrega_correo')->nullable();
            $table->string('fecha_entrega_original')->nullable();
            $table->string('fecha_entrega_email')->nullable();
            $table->string('premio')->nullable();
            $table->string('prima')->nullable();
            $table->string('plan_pago')->nullable();
            $table->integer('cantidad_cuotas')->nullable();
            $table->string('medio_pago')->nullable();
            $table->string('detalle_medio_pago')->nullable();
            $table->string('comision')->nullable();
            $table->string('descuento')->nullable();
            $table->string('archivada')->nullable();
            $table->boolean('flota')->nullable();
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
        Schema::dropIfExists('polizas');
    }
}
