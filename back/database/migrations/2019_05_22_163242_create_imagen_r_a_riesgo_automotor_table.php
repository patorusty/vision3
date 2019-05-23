_<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagenRARiesgoAutomotorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagen_r_a_riesgo_automotor', function (Blueprint $table) {
            $table->integer('imagen_r_a_id')->unsigned();
            $table->foreign('imagen_r_a_id')->references('id')->on('imagen_r_as');
            $table->integer('riesgo_automotor_id')->unsigned();
            $table->foreign('riesgo_automotor_id')->references('id')->on('riesgo_automotors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagen_r_a_riesgo_automotor');
    }
}
