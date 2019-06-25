<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop style="width:75%;">
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
            <tabs
              type="primary"
              tabNavWrapperClasses="col-lg-2 col-md-2"
              tabContentClasses="col-md-10"
              vertical
              square
              class="row"
            >
              <tab-pane>
                <span slot="label">
                  <i class="tim-icons icon-settings"></i>Riesgo
                </span>
                <div class="row">
                  <!-- PRIMER COLUMNA -->
                  <div class="col-md-4">
                    <label>Tipo de Vehiculo</label>
                    <el-select
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_tipo"
                      name="automotor_tipo"
                      :errorSelect="true"
                      id="1"
                    >
                      <el-option
                        v-for="tipo_vehiculo in tipo_vehiculos"
                        :key="tipo_vehiculo.value"
                        :label="tipo_vehiculo.label"
                        :value="tipo_vehiculo.value"
                        class="select-primary "
                      ></el-option>
                    </el-select>

                    <label class="mt-2">Año</label>
                    <el-select
                      filterable
                      class="select-primary"
                      :class="{ errorS: errorSelect.automotor_anio }"
                      v-model="riesgo_automotor.automotor_anio"
                      name="automotor_anio_id"
                      @change="touchSelect('automotor_anio'), reset()"
                    >
                      <el-option
                        v-for="anio in anios"
                        :key="anio.id"
                        :value="anio.id"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect.automotor_anio">
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Marca</label>
                    <el-select
                      v-model="riesgo_automotor.automotor_marca_id"
                      class="select-primary"
                      :class="{ errorS: errorSelect.automotor_marca_id }"
                      filterable
                      @change="
                        filtrarModeloPorMarca(
                          riesgo_automotor.automotor_marca_id
                        );
                        touchSelect('automotor_marca_id');
                      "
                    >
                      <el-option
                        v-for="marca in marcas"
                        :key="marca.id"
                        :value="marca.id"
                        :label="marca.nombre"
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.automotor_marca_id"
                    >
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Modelo</label>
                    <el-select
                      v-model="riesgo_automotor.automotor_modelo_id"
                      class="select-primary"
                      :class="{ errorS: errorSelect.automotor_modelo_id }"
                      filterable
                      @change="
                        filtrarVersionesDeModelo(
                          url,
                          riesgo_automotor.automotor_anio_id,
                          riesgo_automotor.automotor_modelo_id
                        );
                        touchSelect('automotor_modelo_id');
                      "
                    >
                      <el-option
                        v-for="modelo in modelos"
                        :key="modelo.id"
                        :value="modelo.id"
                        :label="modelo.nombre"
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.automotor_modelo_id"
                    >
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Version</label>
                    <el-select
                      v-model="riesgo_automotor.automotor_version_id"
                      :class="{ errorS: errorSelect.automotor_version_id }"
                      class="select-primary"
                      filterable
                      @change="touchSelect('automotor_version_id')"
                    >
                      <el-option
                        v-for="version in versiones"
                        :key="version.automotor_version.id"
                        :value="version.automotor_version.id"
                        :label="version.automotor_version.nombre"
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.automotor_version_id"
                    >
                      Este campo es obligatorio
                    </p>
                    <label>Cobertura</label>
                    <el-select
                      filterable
                      class="select-primary"
                      :class="{ errorS: errorSelect.cobertura_id }"
                      v-model="riesgo_automotor.cobertura_id"
                      name="estado_general"
                      @change="
                        touchSelect('cobertura_id'), coberturaSeleccionada()
                      "
                    >
                      <el-option
                        v-for="cobertura in coberturas"
                        :key="cobertura.id"
                        :label="cobertura.nombre"
                        :value="cobertura.id"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect.cobertura_id">
                      Este campo es obligatorio
                    </p>
                    <base-input
                      class="mt-3"
                      label="Franquicia"
                      v-model="riesgo_automotor.franquicia"
                      name="franquicia"
                      :disabled="cobertura.todo_riesgo == 1"
                    >
                    </base-input>
                  </div>
                  <!-- SEGUNDA COLUMNA -->
                  <div class="col-md-4">
                    <label>Patente</label>
                    <div class="row">
                      <div class="col-md-6">
                        <el-select
                          v-model="riesgo_automotor.tipo_patente"
                          class="select-primary"
                          filterable
                        >
                          <el-option
                            v-for="tipo_patente in tipo_patentes"
                            :key="tipo_patente.value"
                            :value="tipo_patente.value"
                            :label="tipo_patente.label"
                            class="select-primary"
                          >
                          </el-option>
                        </el-select>
                      </div>
                      <div class="col-md-6">
                        <div
                          class="form-group"
                          :class="{ 'has-danger': errors.first('patente') }"
                          v-if="riesgo_automotor.tipo_patente == 0"
                        >
                          <the-mask
                            class="form-control"
                            v-model="riesgo_automotor.patente"
                            name="patente"
                            v-validate="'required'"
                            placeholder="ABC123"
                            style="text-transform:uppercase;"
                            mask="AAA###"
                          >
                          </the-mask>
                          <p
                            class="errorSelect"
                            v-show="errors.first('patente')"
                          >
                            Este campo es obligatorio
                          </p>
                        </div>
                        <div
                          class="form-group"
                          :class="{ 'has-danger': errors.first('patente') }"
                          v-else
                        >
                          <the-mask
                            class="form-control"
                            v-model="riesgo_automotor.patente"
                            placeholder="AB123CD"
                            name="patente"
                            v-validate="'required'"
                            style="text-transform:uppercase;"
                            mask="AA###AA"
                          >
                          </the-mask>
                          <p
                            class="errorSelect"
                            v-show="errors.first('patente')"
                          >
                            Este campo es obligatorio
                          </p>
                        </div>
                      </div>
                    </div>
                    <label>Motor</label>
                    <base-input
                      v-model="riesgo_automotor.nro_motor"
                      name="nro_motor"
                      v-validate="'required'"
                      :error="getError('nro_motor')"
                    >
                    </base-input>
                    <label>Chasis</label>
                    <base-input
                      v-model="riesgo_automotor.nro_chasis"
                      name="nro_chasis"
                      v-validate="'required'"
                      :error="getError('nro_chasis')"
                    >
                    </base-input>
                    <label>Valor Vehiculo</label>
                    <base-input
                      v-model="riesgo_automotor.valor_vehiculo"
                      name="valor_vehiculo"
                      v-validate="'required'"
                      :error="getError('valor_vehiculo')"
                    >
                    </base-input>
                    <div class="mt-4">
                      <base-checkbox v-model="riesgo_automotor.okm"
                        >0km</base-checkbox
                      >
                    </div>
                    <label class="mt-4">Ajuste</label>
                    <el-select
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.ajuste"
                      name="ajuste"
                    >
                      <el-option
                        v-for="ajuste in ajustes"
                        :key="ajuste.value"
                        :label="ajuste.label"
                        :value="ajuste.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>

                    <label class="mt-3">Equipo de Rastreo</label>
                    <el-select
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.equipo_rastreo"
                      name="equipo_rastreo"
                    >
                      <el-option
                        v-for="equipo in equipo_rastreos"
                        :key="equipo.value"
                        :label="equipo.label"
                        :value="equipo.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                  </div>
                  <!-- TERCER COLUMNA -->
                  <div class="col-md-4">
                    <label>Uso</label>
                    <el-select
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

                    <label class="mt-2">Tipo Carroceria</label>
                    <el-select
                      filterable
                      class="select-primary"
                      :class="{ errorS: errorSelect.tipo_carroceria }"
                      v-model="riesgo_automotor.tipo_carroceria"
                      name="tipo_carroceria"
                      @change="touchSelect('tipo_carroceria')"
                    >
                      <el-option
                        v-for="tipo_carroceria in tipo_carrocerias"
                        :key="tipo_carroceria.value"
                        :label="tipo_carroceria.label"
                        :value="tipo_carroceria.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect.tipo_carroceria">
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Combustible</label>
                    <el-select
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
                    <label class="mt-2">Estado General</label>
                    <el-select
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
                    <label class="mt-2">Color</label>
                    <base-input v-model="riesgo_automotor.color" name="color">
                    </base-input>
                    <base-input label="Valor Total" v-model="suma">
                    </base-input>
                    <base-input label="Observaciones">
                      <textarea
                        class="form-control"
                        v-model="riesgo_automotor.observaciones"
                      ></textarea>
                    </base-input>
                  </div>
                </div>
              </tab-pane>
              <tab-pane>
                <p class="text-primary">
                  Cubiertas
                </p>
                <div class="row">
                  <div class="col-md-4">
                    <label>Marca </label>
                    <el-select
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
                  </div>
                  <div class="col-md-4">
                    <label>Medida </label>
                    <base-input
                      v-model="riesgo_automotor.cubiertas_medida"
                      name="cubiertas_medida"
                    >
                    </base-input>
                  </div>
                </div>
                <span slot="label">
                  <i class="tim-icons icon-settings"></i>GNC
                </span>
                <div class="row col-md-4">
                  <p class="text-primary col-md-3" style="padding-left:0px">
                    GNC
                  </p>
                  <base-checkbox
                    class="col-md-6"
                    style="margin-top:-13px"
                    v-model="riesgo_automotor.gnc"
                  >
                  </base-checkbox>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Nro Oblea</label>
                    <base-input
                      :disabled="riesgo_automotor.gnc == false"
                      v-model="riesgo_automotor.gnc_nro_oblea"
                      name="gnc_nro_oblea"
                    >
                    </base-input>
                    <label>Vencimiento Oblea</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        placeholder="Date Picker"
                        v-model="riesgo_automotor.gnc_venc_oblea"
                        :disabled="riesgo_automotor.gnc == false"
                      >
                      </el-date-picker>
                    </base-input>
                    <label>Valor GNC</label>
                    <base-input
                      v-model="riesgo_automotor.valor_gnc"
                      name="valor_gnc"
                      :disabled="riesgo_automotor.gnc == false"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <label>Marca Cilindro</label>
                    <base-input
                      v-model="riesgo_automotor.gnc_marca_cilindro"
                      name="gnc_marca_cilindro"
                      :disabled="riesgo_automotor.gnc == false"
                    >
                    </base-input>
                    <label>Nro Cilindro</label>
                    <base-input
                      v-model="riesgo_automotor.gnc_nro_cilindro"
                      name="gnc_nro_cilindro"
                      :disabled="riesgo_automotor.gnc == false"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <label>Marca Regulador</label>
                    <base-input
                      v-model="riesgo_automotor.gnc_marca_regulador"
                      name="gnc_marca_regulador"
                      :disabled="riesgo_automotor.gnc == false"
                    >
                    </base-input>
                    <label>Nro Regulador</label>
                    <base-input
                      v-model="riesgo_automotor.gnc_nro_regulador"
                      name="gnc_nro_regulador"
                      :disabled="riesgo_automotor.gnc == false"
                    >
                    </base-input>
                  </div>
                </div>
                <p class="text-primary">
                  Accesorios
                </p>
                <div class="row">
                  <div class="col-md-4">
                    <label>Accesorio Nro 1</label>
                    <base-input
                      v-model="riesgo_automotor.accesorio_01"
                      name="accesorio_1"
                    >
                    </base-input>
                    <label>Accesorio Nro 2</label>
                    <base-input
                      v-model="riesgo_automotor.accesorio_02"
                      name="accesorio_2"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <label>Valor Accesorio 1</label>
                    <base-input
                      v-model="riesgo_automotor.valor_accesorio_01"
                      name="valor_accesorio_1"
                    >
                    </base-input>
                    <label>Valor Accesorio 2</label>
                    <base-input
                      v-model="riesgo_automotor.valor_accesorio_02"
                      name="valor_accesorio_2"
                    >
                    </base-input>
                  </div>
                </div>
              </tab-pane>
              <tab-pane>
                <span slot="label">
                  <i class="tim-icons icon-notes"></i>Acreedor Prendario
                </span>
                <base-checkbox
                  class="mb-3"
                  v-model="riesgo_automotor.acreedor_prendario"
                  >Tiene Acreedor Prendario?</base-checkbox
                >
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Razon Social"
                      v-model="riesgo_automotor.acreedor_rs"
                      name="acreedor_rs"
                      :disabled="riesgo_automotor.acreedor_prendario == false"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="CUIT"
                      v-model="riesgo_automotor.acreedor_cuit"
                      name="acreedor_cuit"
                      :disabled="riesgo_automotor.acreedor_prendario == false"
                    >
                    </base-input>
                  </div>
                </div>
              </tab-pane>
              <tab-pane>
                <span slot="label">
                  <i class="tim-icons icon-camera-18"></i>Fotos
                </span>
                <vue-dropzone
                  ref="myVueDropzone"
                  :useCustomSlot="true"
                  :duplicateCheck="true"
                  id="dropzone"
                  :options="dropzoneOptions"
                >
                  <div class="dropzone-custom-content">
                    <div class="texto-drop">
                      Arrastra las fotos aquí...
                    </div>
                  </div>
                  <input
                    style="display: none;"
                    type="text"
                    name="riesgo_id"
                    value="xx"
                  />
                </vue-dropzone>
              </tab-pane>
            </tabs>
            <div
              class="col-md-12 d-flex justify-content-center align-items-stretch"
            >
              <base-button
                @click="crear"
                type="submit"
                class="btn btn-primary ladda-button"
                >Crear</base-button
              >
            </div>
          </form>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { EventBus } from '../../../../main.js';
import { Select, Option, DatePicker } from 'element-ui';
import http from '../../../../API/http-request.js';
import { TabPane, Tabs, Collapse, CollapseItem } from 'src/components';
import { mixin } from '../../../../mixins/mixin.js';
import { BaseSwitch } from 'src/components/index';
import { TheMask } from 'vue-the-mask';
import vue2Dropzone from 'vue2-dropzone';
import 'vue2-dropzone/dist/vue2Dropzone.min.css';

export default {
  props: {
    props: ['poliza'],
    compania_id: {
      type: Number
    }
  },
  mixins: [mixin],
  components: {
    SlideYUpTransition,
    [Select.name]: Select,
    [Option.name]: Option,
    [DatePicker.name]: DatePicker,
    BaseSwitch,
    Collapse,
    CollapseItem,
    TabPane,
    TheMask,
    Tabs,
    vueDropzone: vue2Dropzone
  },
  data: () => ({
    marcas: {},
    marca: {},
    marca_id: '',
    automotor_marcas: {},
    automotor_modelos: {},
    coberturas: [],
    cobertura: {},
    modelos: [],
    modelo: {},
    anios: [],
    versiones: [],
    url: '/anios/filtrar',
    errorSelect: {
      automotor_anio: false,
      automotor_marca_id: false,
      automotor_modelo_id: false,
      automotor_version_id: false,
      cobertura_id: false,
      tipo_carroceria: false
    },
    selected: {
      automotor_anio: false,
      automotor_marca_id: false,
      automotor_modelo_id: false,
      automotor_version_id: false,
      cobertura_id: false,
      tipo_carroceria: false
    },
    riesgo_automotor: {
      automotor_tipo: 'Automotor',
      uso: 'Particular',
      tipo_patente: 1,
      estado_general: 'Muy Bueno',
      ajuste: '0%',
      equipo_rastreo: 'NO',
      combustible: 'Nafta',
      okm: false,
      gnc: false,
      acreedor_prendario: false,
      valor_vehiculo: 0,
      valor_gnc: 0,
      valor_accesorio_01: 0,
      valor_accesorio_02: 0,
      valor_total: '',
      automotor_version_id: ''
    },
    dropzoneOptions: {
      url: 'http://127.0.0.1:8000/api/imagenes_r_a',
      thumbnailWidth: 150,
      maxFilesize: 2,
      addRemoveLinks: true,
      autoProcessQueue: false,
      acceptedFiles: 'image/*',
      method: 'POST',
      dictRemoveFile: 'Remover imagen',
      resizeWidth: 500,
      params: { riesgoId: '' }
    },
    tipo_vehiculos: [
      {
        value: 'Automotor',
        label: 'Automotor'
      },
      {
        value: 'Camion',
        label: 'Camion'
      },
      {
        value: 'Trailer',
        label: 'Trailer'
      }
    ],

    usos: [
      {
        value: 'Particular',
        label: 'Particular'
      },
      {
        value: 'Comercial',
        label: 'Comercial'
      },
      {
        value: 'Particular / Comercial',
        label: 'Particular / Comercial'
      },
      {
        value: 'Remise',
        label: 'Remise'
      },
      {
        value: 'Cabify / Uber',
        label: 'Cabify / Uber'
      }
    ],
    tipo_carrocerias: [
      {
        value: 'Sedan 3 Puertas',
        label: 'Sedan 3 Puertas'
      },
      {
        value: 'Sedan 4 Puertas',
        label: 'Sedan 4 Puertas'
      },
      {
        value: 'Sedan 5 Puertas',
        label: 'Sedan 5 Puertas'
      },
      {
        value: 'Rural',
        label: 'Rural'
      },
      {
        value: 'Utilitario',
        label: 'Utilitario'
      },
      {
        value: 'Berlina',
        label: 'Berlina'
      },
      {
        value: 'Coupe',
        label: 'Coupe'
      },
      {
        value: 'Cabriolet',
        label: 'Cabriolet'
      }
    ],
    tipo_patentes: [
      {
        value: 0,
        label: 'Nacional'
      },
      {
        value: 1,
        label: 'Mercosur'
      }
    ],
    combustibles: [
      {
        value: 'Nafta',
        label: 'Nafta'
      },
      {
        value: 'Diesel',
        label: 'Diesel'
      },
      {
        value: 'GNC',
        label: 'GNC'
      }
    ],
    estados: [
      {
        value: 'Muy Bueno',
        label: 'Muy Bueno'
      },
      {
        value: 'Bueno',
        label: 'Bueno'
      },
      {
        value: 'Regular',
        label: 'Regular'
      }
    ],
    cubiertas_marcas: [
      {
        value: 'Pirelli',
        label: 'Pirelli'
      },
      {
        value: 'Fate',
        label: 'Fate'
      },
      {
        value: 'Continental',
        label: 'Continental'
      },
      {
        value: 'Michelin',
        label: 'Michelin'
      },
      {
        value: 'Dunlop',
        label: 'Dunlop'
      },
      {
        value: 'Goodyear',
        label: 'Goodyear'
      },
      {
        value: 'Hankook',
        label: 'Hankook'
      },
      {
        value: 'Firestone',
        label: 'Firestone'
      },
      {
        value: 'Bridgestone',
        label: 'Bridgestone'
      },
      {
        value: 'Yokohama',
        label: 'Yokohama'
      },
      {
        value: 'Otro',
        label: 'Otro'
      }
    ],
    ajustes: [
      {
        value: '0%',
        label: '0%'
      },
      {
        value: '10%',
        label: '10%'
      },
      {
        value: '20%',
        label: '20%'
      },
      {
        value: '30%',
        label: '30%'
      }
    ],
    equipo_rastreos: [
      {
        value: 'NO',
        label: 'NO'
      },
      {
        value: 'LO JACK',
        label: 'LO JACK'
      },
      {
        value: 'ITURAN',
        label: 'ITURAN'
      },
      {
        value: 'OTRO',
        label: 'OTRO'
      }
    ]
  }),
  computed: {
    suma: function() {
      return (
        parseInt(this.riesgo_automotor.valor_vehiculo) +
        parseInt(this.riesgo_automotor.valor_gnc) +
        parseInt(this.riesgo_automotor.valor_accesorio_01) +
        parseInt(this.riesgo_automotor.valor_accesorio_02)
      );
    }
  },
  methods: {
    close() {
      EventBus.$emit('resetInput', false);
      this.$emit('recargar');
      this.$emit('close');
    },
    uploadImages() {
      this.$refs.myVueDropzone.processQueue();
      console.log(this.$refs.myVueDropzone.dropzone);
    },
    crear() {
      this.$validator.validateAll().then(r => {
        if (this.checkSelect() && r) {
          this.riesgo_automotor.poliza_id = this.$attrs.poliza.id;
          http
            .create('/riesgo_automotor', this.riesgo_automotor)
            .then(r => {
              let rId = r.data.data.id;
              this.dropzoneOptions.params.riesgoId = rId;
              this.uploadImages();
            })
            .then(() => {
              setTimeout(() => this.close(), 500);
            })
            .then(() =>
              this.notifyVue('success', 'El riesgo ha sido creado con exito')
            );
        }
      });
    },
    cargarMarcas() {
      http.load('administracion/marcas', this.marca_id).then(r => {
        this.marcas = r.data.data;
      });
    },
    buscarMarca() {
      http.loadOne('administracion/marcas', this.marca_id).then(r => {
        this.marca = r.data.data;
      });
    },
    filtrarModeloPorMarca(id) {
      this.riesgo_automotor.automotor_modelo_id = '';
      this.versiones = [];
      http.loadOne('/modelos/filtrar', id).then(r => {
        this.modelos = r.data.data;
      });
    },
    filtrarVersionesDeModelo(url, anio, modelo) {
      this.riesgo_automotor.automotor_version_id = '';
      this.versiones = [];
      http.search2(url, anio, modelo).then(r => {
        this.versiones = r.data.data;
      });
    },
    cargarCoberturas() {
      http.loadOne('cobertura/compania', this.compania_id).then(r => {
        this.coberturas = r.data.data;
      });
    },
    cargarAnios() {
      http.load('anios', this.anio_id).then(r => {
        this.anios = r.data.data;
      });
    },

    touchSelect(val) {
      if (
        !this.riesgo_automotor[`${val}`] ||
        this.riesgo_automotor[`${val}`] === undefined
      ) {
        this.selected[val] = false;
        this.errorSelect[val] = true;
      } else {
        this.selected[val] = true;
        this.errorSelect[val] = false;
      }
    },
    checkSelect() {
      let valor = true;
      Object.entries(this.selected).forEach(select => {
        if (select[1] == false && !this.riesgo_automotor[`${select[0]}`]) {
          this.errorSelect[`${select[0]}`] = true;
          valor = false;
        } else {
          this.errorSelect[`${select[0]}`] = false;
          valor = true;
        }
      });
      return valor;
    },
    coberturaSeleccionada() {
      http
        .loadOne('/cobertura', this.riesgo_automotor.cobertura_id)
        .then(r => (this.cobertura = r.data.data));
    },
    reset() {
      this.riesgo_automotor.automotor_marca_id = '';
      this.riesgo_automotor.automotor_modelo_id = '';
      this.riesgo_automotor.automotor_version_id = '';
    }
  },
  created() {
    this.cargarMarcas();
    this.cargarCoberturas();
    this.cargarAnios();
  }
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
}
.div-stop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}
.el-select {
  display: block;
}
.errorSelect {
  color: #ec250d !important;
  font-size: 0.75rem;
  margin-bottom: 5px;
  margin-top: 5px;
}

.vue-dropzone {
  background-color: transparent;
  border-color: #2b3553;
  font-family: Arial, sans-serif;
  letter-spacing: 0.2px;
  color: #777;
  -webkit-transition: 0.2s linear;
  transition: 0.2s linear;
  border-width: 1px;
}

.vue-dropzone:hover {
  background-color: transparent;
  border-color: #e14eca;
  color: #777;
  -webkit-transition: 0.2s linear;
  transition: 0.2s linear;
}
.el-input.is-disabled .el-input__inner {
  background-color: transparent;
  border-color: #2b3553;
}

.texto-drop {
  color: #777;
  text-align: center;
  margin: 2em 0;
  cursor: pointer;
  font-size: 0.875rem;
}

.vue-dropzone > .dz-preview .dz-details {
  background-color: transparent;
}
</style>
