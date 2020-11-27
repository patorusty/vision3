<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Companias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('cuit')->nullable();
            $table->string('direccion')->nullable();
            $table->string('localidad_id')->nullable();
            $table->string('telefono_1')->nullable();
            $table->string('telefono_aux')->nullable();
            $table->string('telefono_siniestros')->nullable();
            $table->string('email_emision')->nullable();
            $table->string('email_siniestros')->nullable();
            $table->integer('codigo_lr')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('activo')->nullable();
            $table->string('color')->nullable();
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
        Schema::dropIfExists('companias');
    }
}
