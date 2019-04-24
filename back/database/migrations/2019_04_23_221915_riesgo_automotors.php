<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RiesgoAutomotors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riesgo_automotors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_id')->nullable();
            $table->string('automotor_tipo')->nullable();
            $table->integer('automotor_anio_id')->nullable();
            $table->integer('automotor_marca_id')->nullable();
            $table->integer('automotor_modelo_id')->nullable();
            $table->integer('automotor_version_id')->nullable();
            $table->string('patente')->nullable();
            $table->string('nro_motor')->nullable();
            $table->string('nro_chasis')->nullable();
            $table->string('uso')->nullable();
            $table->string('tipo_carroceria')->nullable();
            $table->string('combustible')->nullable();
            $table->boolean('okm')->nullable();
            $table->string('estado_general')->nullable();
            $table->string('color')->nullable();
            $table->string('equipo_rastreo')->nullable();
            $table->boolean('gnc')->nullable();
            $table->string('gnc_nro_oblea')->nullable();
            $table->string('gnc_vencimiento_oblea')->nullable();
            $table->string('gnc_nro_regulador')->nullable();
            $table->string('gnc_marca_regulador')->nullable();
            $table->string('gnc_nro_cilindro')->nullable();
            $table->string('gnc_marca_cilindro')->nullable();
            $table->string('cubiertas_medida')->nullable();
            $table->string('cubiertas_marca')->nullable();
            $table->string('accesorio_01')->nullable();
            $table->integer('valor_accesorio_01')->nullable();
            $table->string('accesorio_02')->nullable();
            $table->integer('valor_accesorio_02')->nullable();
            $table->boolean('acreedor_prendario')->nullable();
            $table->string('acreedor_rs')->nullable();
            $table->string('acreedor_cuit')->nullable();
            $table->string('observaciones')->nullable();
            $table->integer('cobertura_id')->nullable();
            $table->string('franquicia')->nullable();
            $table->string('ajuste')->nullable();
            $table->integer('valor_vehiculo')->nullable();
            $table->integer('valor_gnc')->nullable();
            $table->integer('valor_accesorios')->nullable();
            $table->integer('valor_total')->nullable();
            $table->string('vigencia_desde')->nullable();
            $table->string('vigencia_hasta')->nullable();
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
        Schema::dropIfExists('riesgo_automotors');
    }
}
