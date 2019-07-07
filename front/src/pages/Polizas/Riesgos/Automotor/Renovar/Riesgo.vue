<template>
  <div class="modal-contenido">
    <!-- <div class="col-md-12">
      <div class="row ml-1">
        <div class="col-md-6">
          <div class="row ">
            <p class="text-primary">Asegurado: </p> &nbsp;

            <p class="">{{poliza.clientes.apellido}}</p>&nbsp;
            <p class="">{{poliza.clientes.nombre}}</p>
          </div>
          &nbsp;
          <div class="row">
            <p class="text-primary">Compañia: </p> &nbsp;

            <p class="">{{poliza.companias.nombre}}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row">
            <p class="text-primary">Renueva Poliza: </p> &nbsp;

            <p class="">{{poliza.numero}}</p>
          </div>
          &nbsp;
          <div class="row">
            <p class="text-primary">Productor:</p> &nbsp;

            <p class=""></p>
            <p class="">{{poliza.codigo_productor.productores.apellido}}</p>&nbsp;
            <p class="">{{poliza.codigo_productor.productores.nombre}}</p>&nbsp;
            <p> - Cod. &nbsp;(</p>
            <p class="">{{poliza.codigo_productor.codigo_productor}}</p>
            <p>)</p>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-4">
          <label class="mt-2">Año</label>
          <el-select
            filterable
            class="select-primary"
            :class="{ errorS: errorSelect.automotor_anio }"
            v-model="riesgo_automotor.automotor_anio_id"
            name="automotor_anio_id"
            @change="touchSelect('automotor_anio_id'), reset()"
          >
            <el-option
              v-for="anio in anios"
              :key="anio.id"
              :value="anio.id"
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
        </div>
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
            v-model="riesgo_automotor_nuevo.valor_vehiculo"
            name="valor_vehiculo"
            v-validate="'required'"
            :error="getError('valor_vehiculo')"
          >
          </base-input>
        </div>
        <div class="col-md-4">
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
          <p
            class="errorSelect"
            v-show="errorSelect.cobertura_id"
          >
            Este campo es obligatorio
          </p>
          <base-input
            class="mt-3"
            label="Franquicia"
            v-model="riesgo_automotor.franquicia"
            name="franquicia"
            :disabled="cobertura.todo_riesgo == 0"
          >
          </base-input>
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
        </div>
      </div>

    </div> -->
  </div>
</template>
// <script>
// import { mixin } from '../../../../../mixins/mixin.js';
// import { Select, Option, DatePicker } from 'element-ui';
// import http from '../../../../../API/http-request.js';
// import { TheMask } from 'vue-the-mask';

// export default {
//   props: {
//     poliza: {
//       type: Object,
//       required: true,
//       default: null
//     }
//   },
//   mixins: [mixin],
//   name: 'modal-renovar-automotor',
//   components: {
//     [Select.name]: Select,
//     [Option.name]: Option,
//     TheMask
//   },
//   data: () => ({
//           dataLoaded: false,
//       riesgo_automotor_nuevo:{

//       }
//     marcas: {},
//     marca: {},
//     marca_id: '',
//     automotor_marcas: {},
//     automotor_modelos: {},
//     coberturas: [],
//     cobertura: {},
//     modelos: [],
//     modelo: {},
//     anios: [],
//     versiones: [],
//     url: '/anios/filtrar',
//     errorSelect: {
//       automotor_anio_id: false,
//       automotor_marca_id: false,
//       automotor_modelo_id: false,
//       automotor_version_id: false,
//       cobertura_id: false,
//       tipo_carroceria: false
//     },
//     selected: {
//       automotor_anio_id: false,
//       automotor_marca_id: false,
//       automotor_modelo_id: false,
//       automotor_version_id: false,
//       cobertura_id: false,
//       tipo_carroceria: false
//     },
//     tipo_patentes: [
//       {
//         value: 0,
//         label: 'Nacional'
//       },
//       {
//         value: 1,
//         label: 'Mercosur'
//       }
//     ],
//     ajustes: [
//       {
//         value: '0%',
//         label: '0%'
//       },
//       {
//         value: '10%',
//         label: '10%'
//       },
//       {
//         value: '20%',
//         label: '20%'
//       },
//       {
//         value: '30%',
//         label: '30%'
//       }
//     ]
//   }),
//   methods: {
//     cargarMarcas() {
//       http.load('administracion/marcas', this.marca_id).then(r => {
//         this.marcas = r.data.data;
//       });
//     },
//     buscarMarca() {
//       http.loadOne('administracion/marcas', this.marca_id).then(r => {
//         this.marca = r.data.data;
//       });
//     },
//     filtrarModeloPorMarca(id) {
//       this.riesgo_automotor.automotor_modelo_id = '';
//       this.versiones = [];
//       http.loadOne('/modelos/filtrar', id).then(r => {
//         this.modelos = r.data.data;
//       });
//     },
//     filtrarVersionesDeModelo(url, anio, modelo) {
//       this.riesgo_automotor.automotor_version_id = '';
//       this.versiones = [];
//       http.search2(url, anio, modelo).then(r => {
//         this.versiones = r.data.data;
//       });
//     },
//     cargarCoberturas() {
//       http.loadOne('cobertura/compania', this.compania_id).then(r => {
//         this.coberturas = r.data.data;
//       });
//     },
//     cargarAnios() {
//       http.load('anios', this.anio_id).then(r => {
//         this.anios = r.data.data;
//       });
//     },
//     touchSelect(val) {
//       if (
//         !this.riesgo_automotor[`${val}`] ||
//         this.riesgo_automotor[`${val}`] === undefined
//       ) {
//         this.selected[val] = false;
//         this.errorSelect[val] = true;
//       } else {
//         this.selected[val] = true;
//         this.errorSelect[val] = false;
//       }
//     },
//     checkSelect() {
//       let valor = true;
//       Object.entries(this.selected).forEach(select => {
//         if (select[1] == false && !this.riesgo_automotor[`${select[0]}`]) {
//           this.errorSelect[`${select[0]}`] = true;
//           valor = false;
//         } else {
//           this.errorSelect[`${select[0]}`] = false;
//           valor = true;
//         }
//       });
//       return valor;
//     },
//     coberturaSeleccionada() {
//       http
//         .loadOne('/cobertura', this.riesgo_automotor.cobertura_id)
//         .then(r => (this.cobertura = r.data.data));
//     },
//     reset() {
//       this.riesgo_automotor.automotor_marca_id = '';
//       this.riesgo_automotor.automotor_modelo_id = '';
//       this.riesgo_automotor.automotor_version_id = '';
//     }
//   },
//   created() {
//     this.cargarMarcas();
//     this.cargarCoberturas();
//     this.cargarAnios();
//   },
//   mounted() {
//     EventBus.$on('MMV', value => {
//       http.loadOne('/modelos/filtrar', value.automotor_marca_id).then(r => {
//         this.modelos = r.data.data;
//       });
//       http
//         .search2(this.url, value.automotor_anio_id, value.automotor_modelo_id)
//         .then(r => {
//           this.versiones = r.data.data;
//         });
//     });
//   }
// };
//
</script>