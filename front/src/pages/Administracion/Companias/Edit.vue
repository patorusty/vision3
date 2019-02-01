<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">EDITAR COMPAÑIA</h2>
      </div>
    </div>
    <form @submit.prevent="crearCompania()">
      <div class="block">
        <div class="block-body">
          <div class="row">
            <div class="col-md-12">
              <card class="stacked-form">
                <div class="row">

                  <div class="col-md-4">
                    <base-input
                      label="Nombre de la Compañia"
                      type="text"
                      placeholder="Nombre de la Compañia"
                      v-model="compania.nombre"
                    >
                    </base-input>
                    <base-input
                      label="Cuit"
                      type="text"
                      placeholder="Cuit"
                      v-model="compania.cuit"
                    >
                    </base-input>

                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Libros Rubricados"
                      type="text"
                      placeholder="Codigo Libros Rubricados"
                      v-model="compania.codigo_lr"
                    >
                    </base-input>
                    <div class="row">
                      <div class="col-md-6">
                        <base-input
                          label="Color Compañia"
                          type="text"
                          placeholder="Color Compañia"
                          v-model="compania.color"
                        >
                        </base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Compañia Activa?</label>
                        <base-input>
                          <base-switch
                            v-model="switches.defaultOn"
                            type="primary"
                            on-text="ON"
                            off-text="OFF"
                          ></base-switch>
                        </base-input>
                        &nbsp;
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Logo de la Compañia</label>
                    <div class="col-md-4 col-sm-4">
                      <image-upload
                        @change="onImageChange"
                        select-text="Seleccionar Imagen"
                      />
                    </div>
                  </div>
                </div>
              </card>
            </div>
          </div>
        </div>
      </div>
      <div class="block">
        <div class="block-body">
          <div class="row">
            <div class="col-md-12">
              <card class="stacked-form  mb-4">
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Direccion"
                      type="text"
                      placeholder="Direccion"
                      v-model="compania.direccion"
                    >
                    </base-input>

                    <!-- <div class="form-group">
                      <p class="category col-sm ">Localidad</p>
                      <div class="col-md-12">
                        <select
                          name='localidad_id'
                          class="form-control form-control-sm"
                          value='localidad_id'
                          v-model="compania.localidad_id"
                        >
                          <option
                            v-for="localidad in localidades"
                            :key="localidad.id"
                            v-bind:value='localidad.id'
                          >{{localidad.nombre}} / CP: {{localidad.codigo_postal}}</option>
                        </select>
                      </div>
                    </div> -->

                  </div>

                  <div class="col-md-4">
                    <label>Telefono Oficina</label>
                    <base-input
                      type="text"
                      placeholder="Telefono Oficina"
                      v-model="compania.telefono_1"
                      addon-left-icon="tim-icons icon-mobile"
                    >
                    </base-input>
                    <label>Telefono Auxilio</label>
                    <base-input
                      type="text"
                      placeholder="Telefono Auxilio"
                      v-model="compania.telefono_aux"
                      addon-left-icon="tim-icons icon-mobile"
                    >
                    </base-input>
                    <label>Telefono Siniestros</label>
                    <base-input
                      type="text"
                      placeholder="Telefono Siniestros"
                      v-model="compania.telefono_siniestros"
                      addon-left-icon="tim-icons icon-mobile"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <label>Email Emision</label>
                    <base-input
                      required
                      placeholder="Email"
                      v-model="compania.email_emision"
                      v-validate="modelValidations.address"
                      :error="getError('email')"
                      addon-left-icon="tim-icons icon-email-85"
                    >
                    </base-input>
                    <label>Email Siniestros</label>
                    <base-input
                      required
                      placeholder="Email"
                      v-model="compania.email_siniestros"
                      v-validate="modelValidations.address"
                      :error="getError('email')"
                      addon-left-icon="tim-icons icon-email-85"
                    >
                    </base-input>
                  </div>
                </div>
              </card>
              <div class="mb-4">
                <button
                  type="submit"
                  class="btn btn-primary ladda-button"
                > Guardar </button>
              </div>

              <!-- ACA EMPIEZA LA TABLA DE CODIGO ORGANIZADOR -->
              <card>
                <div slot="header">
                  <h4 class="card-title">CODIGOS ORGANIZADOR</h4>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="codigoOrganizadoresTable">
                      <el-table-column
                        min-width="150"
                        prop="name"
                        label="Apellido"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="200"
                        prop="job"
                        label="Nombre"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="since"
                        align="center"
                        label="Matricula"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Cod. Organizador"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Activo"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        header-align="right"
                        align="right"
                        label="Edicion"
                      >
                        <div
                          slot-scope="{
                  row,
                  $index
                }"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Refresh"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              :type="$index > 2 ? 'success' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-refresh-01"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Delete"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              :type="$index > 2 ? 'danger' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-simple-remove"></i>
                            </base-button>
                          </el-tooltip>
                        </div>
                      </el-table-column>
                    </el-table>
                  </div>
                </div>
              </card>
              <!-- !ACA TERMINA LA TABLA DE CODIGO ORGANIZADOR -->
              <!-- ACA EMPIEZA LA TABLA DE CODIGO PRODUCTOR -->
              <card>
                <div slot="header">
                  <h4 class="card-title">CODIGOS PRODUCTOR</h4>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="codigoProductoresTable">
                      <el-table-column
                        min-width="150"
                        prop="name"
                        label="Apellido"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="200"
                        prop="job"
                        label="Nombre"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="since"
                        align="center"
                        label="Matricula"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Cod. Productor"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Cod. Organizador"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Activo"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        header-align="right"
                        align="right"
                        label="Edicion"
                      >
                        <div
                          slot-scope="{
                  row,
                  $index
                }"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Refresh"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              :type="$index > 2 ? 'success' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-refresh-01"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Delete"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              :type="$index > 2 ? 'danger' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-simple-remove"></i>
                            </base-button>
                          </el-tooltip>
                        </div>
                      </el-table-column>
                    </el-table>
                  </div>
                </div>
              </card>
              <!-- !ACA TERMINA LA TABLA DE CODIGO PRODUCTOR -->
              <!-- ACA EMPIEZA COBERTURAS -->
              <card>
                <div slot="header">
                  <h4 class="card-title">COBERTURAS</h4>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="coberturasTable">
                      <el-table-column
                        min-width="150"
                        prop="name"
                        label="Nombre"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="200"
                        prop="job"
                        label="Antiguedad"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="since"
                        align="center"
                        label="Todo Riesgo"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Franquicia"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Ajuste"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        prop="salary"
                        align="right"
                        label="Activa"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        header-align="right"
                        align="right"
                        label="Edicion"
                      >
                        <div
                          slot-scope="{
                  row,
                  $index
                }"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Refresh"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              :type="$index > 2 ? 'success' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-refresh-01"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Delete"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              :type="$index > 2 ? 'danger' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-simple-remove"></i>
                            </base-button>
                          </el-tooltip>
                        </div>
                      </el-table-column>
                    </el-table>
                  </div>
                </div>
              </card>
              <!-- !ACA TERMINA COBERTURAS -->
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import axios from 'axios';
import { Table, TableColumn } from 'element-ui';

import {
  BaseProgress,
  BaseSwitch,
  ImageUpload,
  TagsInput
} from 'src/components/index';
export default {
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    ImageUpload,
    BaseSwitch
  },
  data() {
    return {
      codigoOrganizadoresTable: [
        {
          id: 1,
          img: 'img/tania.jpg',
          name: 'Tania Mike',
          job: 'Develop',
          progress: 25,
          since: 2013,
          salary: '€ 99,225'
        }
      ],
      codigoProductoresTable: [
        {
          id: 1,
          img: 'img/tania.jpg',
          name: 'Tania Mike',
          job: 'Develop',
          progress: 25,
          since: 2013,
          salary: '€ 99,225'
        }
      ],
      coberturasTable: [
        {
          id: 1,
          img: 'img/tania.jpg',
          name: 'Tania Mike',
          job: 'Develop',
          progress: 25,
          since: 2013,
          salary: '€ 99,225'
        }
      ],
      modelValidations: {
        email: {
          required: true,
          email: true
        },
        phone: {
          required: true,
          numeric: true
        }
      },

      compania: {},
      // localidades: {},
      images: {
        regular: null
      },
      switches: {
        defaultOn: true,
        defaultOff: false
      }
    };
  },
  methods: {
    getError(fieldName) {
      return this.errors.first(fieldName);
    },
    onImageChange(file) {
      this.images.regular = file;
    },
    // FUNCIONES COMPANIA //

    cargarCompania() {
      axios
        .get(
          'http://127.0.0.1:8000/api/administracion/companias/' +
            this.nombreCompania
        )
        .then(response => {
          this.compania = response.data.data[0];
          axios
            .get(
              'http://127.0.0.1:8000/api/codigoorganizador/compania/' +
                this.compania.id
            )
            .then(response => {
              this.codigo_organizadores = response.data.data;
            })
            .catch(err => {
              console.log(err);
            });
          axios
            .get(
              'http://127.0.0.1:8000/api/codigoproductor/compania/' +
                this.compania.id
            )
            .then(response => {
              this.codigo_productores = response.data.data;
            })
            .catch(err => {
              console.log(err);
            });
          axios
            .get(
              'http://127.0.0.1:8000/api/cobertura/compania/' + this.compania.id
            )
            .then(response => {
              this.coberturas = response.data.data;
            })
            .catch(err => {
              console.log(err);
            });
        });
    },

    updateCompania() {
      axios
        .put(
          'http://127.0.0.1:8000/api/administracion/companias/' +
            this.compania.id,
          this.compania
        )
        .then(() => {
          console.log('update ok');
          window.location.replace(
            'http://127.0.0.1:8000/administracion/companias/' +
              this.compania.nombre +
              '/edit'
          );
        });
    },

    //FIN - FUNCIONES COMPANIA //

    cargarLocalidades() {
      axios
        .get('http://127.0.0.1:8000/api/localidades')
        .then(function(response) {
          this.localidades = response.data.data;
        });
    },
    vaciarForm() {
      this.modoEditar = false;
      this.codigo_organizador = {};
      this.codigo_productor = {};
      this.cobertura = {};
      this.compania.activo = 1;
    },

    // FUNCIONES CODIGO ORGANIZADOR //
    cargarCodigo_Organizador() {
      axios
        .get(
          'http://127.0.0.1:8000/api/codigoorganizador/compania/' +
            this.compania.id
        )
        .then(response => {
          this.dataLoaded = true;
          this.codigo_organizadores = response.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    crearCodigo_Organizador() {
      this.codigo_organizador.compania_id = this.compania.id;
      axios
        .post(
          'http://127.0.0.1:8000/api/codigoorganizador',
          this.codigo_organizador
        )
        .then(() => {
          $('#modalcodigoorganizador').modal('hide');
          this.codigo_organizador = {};
          this.codigo_organizador.activo = true;
          this.cargarCodigo_Organizador();
        })
        .catch(e => console.log(e));
    },
    updateCodigo_Organizador(id) {
      axios
        .put(
          'http://127.0.0.1:8000/api/codigoorganizador/' + id,
          this.codigo_organizador
        )
        .then(() => {
          $('#modalcodigoorganizador').modal('hide');
          this.cargarCodigo_Organizador();
          console.log('listo!');
        })
        .catch(e => console.log(e));
    },
    editarCodigo_Organizador(id) {
      (this.modoEditar = true), $('#modalcodigoorganizador').modal('show');
      axios
        .get('http://127.0.0.1:8000/api/codigoorganizador/' + id)
        .then(function(response) {
          this.codigo_organizador = response.data.data;
        })
        .catch(e => console.log(e));
    },
    borrarCodigo_Organizador(id) {
      axios
        .delete('http://127.0.0.1:8000/api/codigoorganizador/' + id)
        .then(() => {
          this.cargarCodigo_Organizador();
          console.log('borado!');
        });
    },

    // FIN - FUNCIONES CODIGO ORGANIZADOR //

    // FUNCIONES CODIGO PRODUCTOR //

    // FIN - FUNCIONES CODIGO PRODUCTOR

    // FUNCIONES COBERTURAS //

    //FIN - FUNCIONES COBERTURAS //

    cargarOrganizadores() {
      axios
        .get('http://127.0.0.1:8000/api/administracion/organizadores')
        .then(response => {
          this.organizadores = response.data.data;
        });
    },
    cargarProductores() {
      axios
        .get('http://127.0.0.1:8000/api/administracion/productores')
        .then(response => {
          this.productores = response.data.data;
        });
    }
  },

  created() {
    this.cargarLocalidades();
    this.cargarCompania();
    // this.cargarCobertura();
  }
};
</script>
