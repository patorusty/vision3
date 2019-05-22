<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagenRiesgoAutomotorRiesgoAutomotorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagen_riesgo_automotor_riesgo_automotor', function (Blueprint $table) {
            $table->integer('imagen_riesgo_automotor_id');
            $table->integer('riesgo_automotor_id');
            $table->primary(['imagen_riesgo_automotor_id','riesgo_automotor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagen_riesgo_automotor_riesgo_automotor');
    }
}
