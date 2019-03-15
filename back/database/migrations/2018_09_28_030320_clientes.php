<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_persona')->nullable();
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('tipo_doc')->nullable();
            $table->integer('nro_dni')->nullable();
            $table->string('sexo')->nullable();
            $table->string('nacimiento')->nullable();
            $table->string('condicion_fiscal')->nullable();
            $table->string('cuit')->nullable();
            $table->integer('registro')->nullable();
            $table->string('vencimiento_registro')->nullable();
            $table->string('email')->nullable();
            $table->string('email_alt')->nullable();
            $table->string('direccion')->nullable();
            $table->string('direccion_nro')->nullable();
            $table->string('direccion_piso')->nullable();
            $table->string('direccion_depto')->nullable();
            $table->integer('localidad_id')->nullable();
            $table->string('barrio_cerrado')->nullable();
            $table->string('lote')->nullable();
            $table->string('celular')->nullable();
            $table->string('telefono_1')->nullable();
            $table->string('telefono_2')->nullable();
            $table->string('img_registro')->nullable();
            $table->string('observaciones_1')->nullable();
            $table->string('observaciones_2')->nullable();
            $table->integer('productor_id')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
