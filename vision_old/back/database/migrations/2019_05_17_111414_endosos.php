<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Endosos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endosos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_id')->nullable();
            $table->integer('tipo_endoso_id')->nullable();
            $table->integer('detalle_endoso_id')->nullable();
            $table->string('fecha_solicitud')->nullable();
            $table->string('fecha_emision')->nullable();
            $table->string('detalle')->nullable();
            $table->string('numero_endoso')->nullable();
            $table->boolean('completo')->nullable();
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
        Schema::dropIfExists('endosos');
    }
}
