<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiniestroAutomotors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siniestro_automotors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_id')->nullable();
            $table->string('numero_siniestro')->nullable();
            $table->string('fecha_denuncia')->nullable();
            $table->string('fecha_siniestro')->nullable();
            $table->string('fecha_completo')->nullable();
            $table->string('tipo_reclamo')->nullable();
            $table->string('estado_siniestro')->nullable();
            $table->string('inspeccion')->nullable();
            $table->string('orden_trabajo')->nullable();
            $table->string('cleas')->nullable();
            $table->string('ciavscia')->nullable();
            $table->string('culpabilidad')->nullable();
            $table->string('taller')->nullable();
            $table->string('detalle')->nullable();
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
        Schema::dropIfExists('siniestro_automotors');

    }
}
