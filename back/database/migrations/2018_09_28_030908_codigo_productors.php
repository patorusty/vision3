<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CodigoProductors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_productors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_productor')->nullable();
            $table->integer('codigo_organizador_id')->nullable();
            $table->integer('productor_id')->nullable();
            $table->integer('compania_id')->nullable();
            $table->boolean('activo')->nullable();
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
        Schema::dropIfExists('codigo_productors');
    }
}
