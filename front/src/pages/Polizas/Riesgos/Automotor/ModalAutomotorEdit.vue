<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @keydown.esc="close"
      @click="close"
    >
      <div
        @click.stop
        style="width:75%;"
      >
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
                    >
                      <el-option
                        v-for="tipo_vehiculo in tipo_vehiculos"
                        :key="tipo_vehiculo.value"
                        :label="tipo_vehiculo.label"
                        :value="tipo_vehiculo.value"
                        class="select-primary "
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.automotor_tipo"
                    >
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Año</label>
                    <el-select
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.automotor_anio"
                      name="automotor_anio_id"
                    >
                      <el-option
                        v-for="anio in anios"
                        :key="anio.value"
                        :label="anio.label"
                        :value="anio.value"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.automotor_anio"
                    >
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Marca</label>
                    <el-select
                      v-model="riesgo_automotor.automotor_marca_id"
                      class="select-primary"
                      filterable
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
                      filterable
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
                      class="select-primary"
                      filterable
                    >
                      <el-option
                        v-for="version in versiones"
                        :key="version.id"
                        :value="version.id"
                        :label="version.nombre"
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
                  </div>
                  <!-- SEGUNDA COLUMNA -->
                  <div class="col-md-4">
                    <label>Patente</label>
                    <base-input
                      v-model="riesgo_automotor.patente"
                      name="patente"
                      v-validate="'required'"
                    >
                    </base-input>
                    <label>Motor</label>
                    <base-input
                      v-model="riesgo_automotor.nro_motor"
                      name="motor"
                      v-validate="'required'"
                    >
                    </base-input>
                    <label>Chasis</label>
                    <base-input
                      v-model="riesgo_automotor.nro_chasis"
                      name="chasis"
                      v-validate="'required'"
                    >
                    </base-input>
                    <label>Valor Vehiculo</label>
                    <base-input
                      v-model="riesgo_automotor.valor_vehiculo"
                      name="valor_vehiculo"
                      v-validate="'required'"
                    >
                    </base-input>
                    <div class="mt-4">
                      <base-checkbox v-model="riesgo_automotor.okm">0km</base-checkbox>
                    </div>
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
                    <p
                      class="errorSelect"
                      v-show="errorSelect.uso"
                    >
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Tipo Carroceria</label>
                    <el-select
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
                    <p
                      class="errorSelect"
                      v-show="errorSelect.tipo_carroceria"
                    >
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
                    <p
                      class="errorSelect"
                      v-show="errorSelect.combustible"
                    >
                      Este campo es obligatorio
                    </p>
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
                    <p
                      class="errorSelect"
                      v-show="errorSelect.estado_general"
                    >
                      Este campo es obligatorio
                    </p>
                    <label class="mt-2">Color</label>
                    <base-input
                      v-model="riesgo_automotor.color"
                      name="color"
                    >
                    </base-input>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Cobertura</label>
                    <el-select
                      filterable
                      class="select-primary"
                      v-model="riesgo_automotor.cobertura_id"
                      name="estado_general"
                    >
                      <el-option
                        v-for="cobertura in coberturas"
                        :key="cobertura.id"
                        :label="cobertura.nombre"
                        :value="cobertura.id"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.cobertura_id"
                    >
                      Este campo es obligatorio
                    </p>
                    <div v-if="riesgo_automotor.cobertura_id === 10">
                      <base-input
                        class="mt-3"
                        placeholder="if"
                        label="Franquicia"
                        v-model="riesgo_automotor.franquicia"
                        name="franquicia"
                      >
                      </base-input>
                    </div>
                    <div v-else>
                      <base-input
                        placeholder="else"
                        class="mt-3"
                        label="Franquicia"
                        v-model="riesgo_automotor.franquicia"
                        name="franquicia"
                      >
                      </base-input>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Ajuste</label>
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
                    <p
                      class="errorSelect"
                      v-show="errorSelect.ajuste"
                    >
                      Este campo es obligatorio
                    </p>
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
                    <p
                      class="errorSelect"
                      v-show="errorSelect.equipo_rastreo"
                    >
                      Este campo es obligatorio
                    </p>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Valor Total"
                      v-model="riesgo_automotor.valor_total"
                      name="valor_total"
                    >
                    </base-input>
                    <base-input label="Observaciones">
                      <textarea
                        class="form-control"
                        v-model="riesgo_automotor.observaciones"
                      ></textarea>
                    </base-input>

                    <!-- {{ riesgo_automotor.vigencia_desde }}
                    {{ riesgo_automotor.vigencia_hasta }} -->
                  </div>
                </div>
              </tab-pane>

              <tab-pane>
                <span slot="label">
                  <i class="tim-icons icon-settings"></i>GNC
                </span>
                <base-checkbox
                  class="mb-3"
                  v-model="riesgo_automotor.gnc"
                >Tiene GNC?</base-checkbox>
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Nro Oblea"
                      v-model="riesgo_automotor.gnc_nro_oblea"
                      name="gnc_nro_oblea"
                    >
                    </base-input>
                    <base-input label="Vencimiento Oblea">
                      <el-date-picker
                        type="date"
                        placeholder="Date Picker"
                        v-model="riesgo_automotor.gnc_venc_oblea"
                      >
                      </el-date-picker>
                    </base-input>
                    <base-input
                      label="Valor GNC"
                      v-model="riesgo_automotor.valor_gnc"
                      name="valor_gnc"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Marca Cilindro"
                      v-model="riesgo_automotor.gnc_marca_cilindro"
                      name="gnc_marca_cilindro"
                    >
                    </base-input>
                    <base-input
                      label="Nro Cilindro"
                      v-model="riesgo_automotor.gnc_nro_cilindro"
                      name="gnc_nro_cilindro"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Marca Regulador"
                      v-model="riesgo_automotor.gnc_marca_regulador"
                      name="gnc_marca_regulador"
                    >
                    </base-input>
                    <base-input
                      label="Nro Regulador"
                      v-model="riesgo_automotor.gnc_nro_regulador"
                      name="gnc_nro_regulador"
                    >
                    </base-input>
                  </div>
                </div>
              </tab-pane>
              <tab-pane>
                <span slot="label">
                  <i class="tim-icons icon-settings"></i>Cubiertas / Accesorios
                </span>
                <div class="row">
                  <div class="col-md-4">
                    <label>Marca Cubiertas</label>
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
                    <base-input
                      class="mt-3"
                      label="Medida Cubiertas"
                      v-model="riesgo_automotor.cubiertas_medida"
                      name="cubiertas_medida"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Accesorio Nro 1"
                      v-model="riesgo_automotor.accesorio_01"
                      name="accesorio_1"
                    >
                    </base-input>
                    <base-input
                      label="Accesorio Nro 2"
                      v-model="riesgo_automotor.accesorio_02"
                      name="accesorio_2"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Valor Accesorio 1"
                      v-model="riesgo_automotor.valor_accesorio_01"
                      name="valor_accesorio_1"
                    >
                    </base-input>
                    <base-input
                      label="Valor Accesorio 2"
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
                >Tiene Acreedor Prendario?</base-checkbox>
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Razon Social"
                      v-model="riesgo_automotor.acreedor_rs"
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
              </tab-pane>
            </tabs>
            <div class="col-md-12 d-flex justify-content-center">
              <base-button type="primary">Guardar</base-button>
            </div>
          </form>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Card } from 'src/components';
import { EventBus } from '../../../../main.js';
import { Select, Option, DatePicker } from 'element-ui';
import http from '../../../../API/http-request.js';
import { TabPane, Tabs, Collapse, CollapseItem } from 'src/components';

export default {
  props: {
    // riesgo_automotor: {
    //   type: Object
    // },
    compania_id: {
      type: Number
    }
  },
  components: {
    SlideYUpTransition,
    [Select.name]: Select,
    [Option.name]: Option,
    [DatePicker.name]: DatePicker,
    Collapse,
    CollapseItem,
    TabPane,
    Tabs
  },
  methods: {
    close() {
      EventBus.$emit('resetInput', false);
      this.$emit('close');
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
    filtrarModeloPorMarca() {
      http.loadOne('/modelos/filtrar', this.marca_id).then(r => {
        this.tableData = r.data.data;
        this.buscarMarca();
        this.modalListo = true;
      });
    },
    filtrarVersionesDeModelo() {
      http.loadOne('/versiones/filtrar', this.modelo_id).then(r => {
        this.tableData = r.data.data;
        this.modeloSeleccionado = this.tableData[0];
        this.modalListo = true;
      });
    },
    cargarCoberturas() {
      http.loadOne('cobertura/compania', this.compania_id).then(r => {
        this.coberturas = r.data.data;
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
        if (select[1] == false) {
          this.errorSelect[`${select[0]}`] = true;
          valor = false;
        }
      });
      return valor;
    }
  },
  created() {
    this.cargarMarcas();
    this.cargarCoberturas();
  },
  data: () => ({
    marcas: {},
    marca: {},
    marca_id: '',
    automotor_marcas: {},
    automotor_modelos: {},
    coberturas: [],
    modelos: [],
    versiones: {},
    errorSelect: {
      automotor_tipo: false,
      automotor_anio: false,
      automotor_marca_id: false,
      automotor_modelo_id: false,
      automotor_version_id: false,
      uso: false,
      tipo_carroceria: false,
      combustible: false,
      estado_general: false,
      cobertura_id: false,
      estado_general: false,
      ajuste: false,
      equipo_rastreo: false
    },
    selected: {
      automotor_tipo: false,
      automotor_anio: false,
      automotor_marca_id: false,
      automotor_modelo_id: false,
      automotor_version_id: false,
      uso: false,
      tipo_carroceria: false,
      combustible: false,
      estado_general: false,
      cobertura_id: false,
      estado_general: false,
      ajuste: false,
      equipo_rastreo: false
    },
    riesgo_automotor: {
      automotor_tipo: 'Automotor',
      uso: 'Particular',
      estado_general: 'Muy Bueno',
      ajuste: '0%',
      equipo_rastreo: 'NO',
      combustible: 'Nafta'
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
    anios: [
      {
        value: '2019',
        label: '2019'
      },
      {
        value: '2018',
        label: '2018'
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
</style>
