<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop class="div-stop">
        <div style="width:50%;">
          <div class="">
            <card>
              <form>
                <div class="d-flex justify-content-between">
                  <!-- ACA VA EL TITULO -->
                  <h4>Automotor</h4>
                  <button
                    class="close"
                    type="button"
                    aria-label="Close"
                    @click="close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <!-- ACA VA EL FORMULARIO -->
                <div class="row">
                  <!-- PRIMER COLUMNA -->
                  <div class="col-md-4">
                    <el-select
                      label="Tipo Vehiculo"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_tipo"
                      name="automotor_tipo"
                    >
                      <el-option
                        v-for="tipo_vehiculo in tipo_vehiculos"
                        :key="tipo_vehiculo.value"
                        :label="tipo_vehiculo.label"
                        :value="tipo_vehiculo.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Año"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_anio"
                      name="automotor_anio_id"
                    >
                      <el-option
                        v-for="anio in anios"
                        :key="anio.id"
                        :label="anio.nombre"
                        :id="anio.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Marca"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_marca"
                      name="automotor_marca_id"
                    >
                      <el-option
                        v-for="marca in marcas"
                        :key="marca.id"
                        :label="marca.nombre"
                        :id="marca.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Modelo"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_modelo"
                      name="automotor_modelo_id"
                    >
                      <el-option
                        v-for="modelo in modelos"
                        :key="modelo.id"
                        :label="modelo.nombre"
                        :value="modelo.id"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Version"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_version_id"
                      name="automotor_version_id"
                    >
                      <el-option
                        v-for="version in versiones"
                        :key="version.id"
                        :label="version.nombre"
                        :value="version.id"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                  </div>
                  <!-- SEGUNDA COLUMNA -->
                  <div class="col-md-4">
                    <base-input
                      label="Patente"
                      v-model="riesgo_automotor.patente"
                      name="patente"
                    >
                    </base-input>
                    <base-input
                      label="Motor"
                      v-model="riesgo_automotor.nro_motor"
                      name="motor"
                    >
                    </base-input>
                    <base-input
                      label="Chasis"
                      v-model="riesgo_automotor.nro_chasis"
                      name="chasis"
                    >
                    </base-input>
                    <base-checkbox
                      label="0km"
                      v-model="riesgo_automotor.okm"
                      name="0km"
                    ></base-checkbox>
                    <base-input
                      label="Valor Vehiculo"
                      v-model="riesgo_automotor.valor_vehiculo"
                      name="valor_vehiculo"
                    >
                    </base-input>
                  </div>
                  <!-- TERCER COLUMNA -->
                  <div class="col-md-4">
                    <el-select
                      label="Uso"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.uso"
                      name="uso"
                    >
                      <el-option
                        v-for="usos in usos"
                        :key="usos.value"
                        :label="usos.label"
                        :value="usos.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Tipo Carroceria"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.tipo_carroceria"
                      name="tipo_carroceria"
                    >
                      <el-option
                        v-for="tipo_carroceria in tipo_carrocerias"
                        :key="tipo_carroceria.value"
                        :label="tipo_carroceria.label"
                        :value="tipo_carroceria.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Combustible"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.combustible"
                      name="combustible"
                    >
                      <el-option
                        v-for="combustible in combustibles"
                        :key="combustible.value"
                        :label="combustible.label"
                        :value="combustible.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <el-select
                      label="Estado General"
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.estado_general"
                      name="estado_general"
                    >
                      <el-option
                        v-for="estado in estados"
                        :key="estado.value"
                        :label="estado.label"
                        :value="estado.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <base-input
                      label="Color"
                      v-model="riesgo_automotor.color"
                      name="color"
                    >
                    </base-input>
                  </div>
                </div>
                <!-- <collapse :multiple-active="false" :active-index="0">
                  <collapse-item title="GNC">
                    <div>
                      <div class="row">
                        <div class="col-md-4">
                          <base-input
                            label="Nro Oblea"
                            v-model="riesgo_automotor.gnc_nro_oblea"
                            name="color"
                          >
                          </base-input>
                          <base-input
                            label="Vencimiento Oblea"
                            v-model="riesgo_automotor.gnc_venc_oblea"
                            name="color"
                          >
                          </base-input>
                          <base-input
                            label="Valor GNC"
                            v-model="riesgo_automotor.valor_gnc"
                            name="color"
                          >
                          </base-input>
                        </div>
                        <div class="col-md-4">
                          <base-input
                            label="Valor GNC"
                            v-model="riesgo_automotor.gnc_marca_cilindro"
                            name="color"
                          >
                          </base-input>
                          <base-input
                            label="Valor GNC"
                            v-model="riesgo_automotor.gnc_nro_cilindro"
                            name="color"
                          >
                          </base-input>
                        </div>
                        <div class="col-md-4">
                          <base-input
                            label="Valor GNC"
                            v-model="riesgo_automotor.gnc_marca_regulador"
                            name="color"
                          >
                          </base-input>
                          <base-input
                            label="Valor GNC"
                            v-model="riesgo_automotor.gnc_nro_regulador"
                            name="color"
                          >
                          </base-input>
                        </div>
                      </div>
                    </div>
                  </collapse-item>

                  <collapse-item title="Cubiertas / Accesorios">
                    <div>
                      <div class="row">
                        <div class="col-md-4">
                          <el-select
                            label="Marca Cubiertas"
                            filterable
                            class="select-primary"
                            v-model="riesgo_automotor.cubiertas_marca"
                            name="cubiertas_marca"
                          >
                            <el-option
                              v-for="cubiertas_marca in cubiertas_marcas"
                              :key="cubiertas_marca.value"
                              :label="cubiertas_marca.label"
                              :value="cubiertas_marca.value"
                              class="select-primary"
                            ></el-option>
                          </el-select>
                          <base-input
                            label="Medida Cubiertas"
                            v-model="riesgo_automotor.cubiertas_medidas"
                            name="cubiertas_medidas"
                          >
                          </base-input>
                        </div>
                        <div class="col-md-4">
                          <base-input
                            label="Accesorio Nro 1"
                            v-model="riesgo_automotor.accesorio_1"
                            name="accesorio_1"
                          >
                          </base-input>
                          <base-input
                            label="Valor Accesorio 1"
                            v-model="riesgo_automotor.valor_accesorio_1"
                            name="valor_accesorio_1"
                          >
                          </base-input>
                        </div>
                        <div class="col-md-4">
                          <base-input
                            label="Accesorio Nro 2"
                            v-model="riesgo_automotor.accesorio_2"
                            name="accesorio_2"
                          >
                          </base-input>
                          <base-input
                            label="Valor Accesorio 2"
                            v-model="riesgo_automotor.valor_accesorio_2"
                            name="valor_accesorio_2"
                          >
                          </base-input>
                        </div>
                      </div>
                    </div>
                  </collapse-item>

                  <collapse-item title="Acreedor Prendario">
                    <div>
                      <div class="row">
                        <div class="col-md-4">
                          <base-input
                            label="Razon Social"
                            v-model="riesgo_automotor.acreedor_rc"
                            name="acreedor_rc"
                          >
                          </base-input>
                        </div>
                        <div class="col-md-4">
                          <base-input
                            label="CUIT"
                            v-model="riesgo_automotor.acreedor_cuit"
                            name="acreedor_cuit"
                          >
                          </base-input>
                        </div>
                      </div>
                    </div>
                  </collapse-item>
                  <collapse-item title="Observaciones">
                    <base-input label="Observaciones">
                      <textarea
                        class="form-control"
                        v-model="riesgo_automotor.observaciones"
                      ></textarea>
                    </base-input>
                  </collapse-item>
                </collapse> -->
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Cobertura"
                      v-model="riesgo_automotor.cobertura_id"
                      name="cobertura_id"
                    >
                    </base-input>
                    <base-input
                      label="Franquicia"
                      v-model="riesgo_automotor.franquicia"
                      name="franquicia"
                    >
                    </base-input>
                    <base-input
                      label="Ajuste"
                      v-model="riesgo_automotor.ajuste"
                      name="ajuste"
                    >
                    </base-input>
                    <base-input
                      label="Equipo de Rastreo"
                      v-model="riesgo_automotor.equipo_rastreo"
                      name="equipo_rastreo"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Valor Total"
                      v-model="riesgo_automotor.valor_total"
                      name="valor_total"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    {{ riesgo_automotor.vigencia_desde }}
                    {{ riesgo_automotor.vigencia_hasta }}
                  </div>
                </div>
                <div class="modal-pie pull-right mt-3">
                  <base-button
                    class="btn btn-primary ladda-button"
                    type="submit"
                    >Guardar</base-button
                  >
                  >
                </div>
              </form>
            </card>
          </div>
        </div>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Select, Option } from 'element-ui';
import { Collapse, CollapseItem } from 'src/components';
import { BaseAlert } from 'src/components';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import { mixin } from '../../../../mixins/mixin.js';
// import debounce from '../../../../debounce.js';

export default {
  componens: {
    SlideYUpTransition,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseAlert,
    Collapse,
    CollapseItem,
    BaseButton,
    Card
  },
  props: ['riesgo_automotor'],
  mixins: [mixin],
  methods: {
    close() {
      EventBus.$emit('resetInput', false);
      this.$emit('close');
    },
    cargarMarcas() {
      http.load('administracion/marcas').then(r => {
        this.marcas = r.data.data;
      });
    },
    cargarAnios() {
      http.load('administracion/anios').then(r => {
        this.anios = r.data.data;
      });
    },
    filtrarModelosDeMarca() {
      this.modelo_id = '';
      this.tableData = [];
      http
        .loadOne('/modelos/filtrar', this.marca_id)
        .then(r => (this.modelos = r.data.data));
    },
    filtrarVersionesDeModelo() {
      http.loadOne('/versiones/filtrar', this.modelo_id).then(r => {
        this.versiones = r.data.data;
        // this.modeloSeleccionado = this.tableData[0];
      });
    }
  },
  created() {
    this.cargarMarcas();
  },
  data: () => ({
    marcas: [],
    modelos: [],
    versiones: [],
    anios: [],
    tipo_vehiculos: [
      {
        value: 'Automotor',
        labe: 'Automotor'
      },
      {
        value: 'Camion',
        labe: 'Camion'
      },
      {
        value: 'Trailer',
        labe: 'Trailer'
      }
    ],
    usos: [
      {
        value: 'Particular',
        labe: 'Particular'
      },
      {
        value: 'Comercial',
        labe: 'Comercial'
      },
      {
        value: 'Particular / Comercial',
        labe: 'Particular / Comercial'
      },
      {
        value: 'Remise',
        labe: 'Remise'
      },
      {
        value: 'Cabify / Uber',
        labe: 'Cabify / Uber'
      }
    ],
    tipo_carrocerias: [
      {
        value: 'Sedan 3 Puertas',
        labe: 'Sedan 3 Puertas'
      },
      {
        value: 'Sedan 4 Puertas',
        labe: 'Sedan 4 Puertas'
      },
      {
        value: 'Sedan 5 Puertas',
        labe: 'Sedan 5 Puertas'
      },
      {
        value: 'Rural',
        labe: 'Rural'
      },
      {
        value: 'Utilitario',
        labe: 'Utilitario'
      },
      {
        value: 'Berlina',
        labe: 'Berlina'
      },
      {
        value: 'Coupe',
        labe: 'Coupe'
      },
      {
        value: 'Cabriolet',
        labe: 'Cabriolet'
      }
    ],
    combustibles: [
      {
        value: 'Nafta',
        labe: 'Nafta'
      },
      {
        value: 'Diesel',
        labe: 'Diesel'
      },
      {
        value: 'GNC',
        labe: 'GNC'
      }
    ],
    estados: [
      {
        value: 'Muy Bueno',
        labe: 'Muy Bueno'
      },
      {
        value: 'Bueno',
        labe: 'Bueno'
      },
      {
        value: 'Regular',
        labe: 'Regular'
      }
    ],
    cubiertas_marcas: [
      {
        value: 'Pirelli',
        labe: 'Pirelli'
      },
      {
        value: 'Fate',
        labe: 'Fate'
      },
      {
        value: 'Continental',
        labe: 'Continental'
      },
      {
        value: 'Michelin',
        labe: 'Michelin'
      },
      {
        value: 'Dunlop',
        labe: 'Dunlop'
      },
      {
        value: 'Goodyear',
        labe: 'Goodyear'
      },
      {
        value: 'Hankook',
        labe: 'Hankook'
      },
      {
        value: 'Firestone',
        labe: 'Firestone'
      },
      {
        value: 'Bridgestone',
        labe: 'Bridgestone'
      },
      {
        value: 'Yokohama',
        labe: 'Yokohama'
      },
      {
        value: 'Otro',
        labe: 'Otro'
      }
    ]
  })
};
</script>
<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
