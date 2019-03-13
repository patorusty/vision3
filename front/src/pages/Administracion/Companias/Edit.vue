<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <div class="row">
          <h4 class="text-primary">EDITAR /</h4>
          <h4 class="">{{ compania.nombre }}</h4>
        </div>
      </div>
    </div>
    <form @submit.prevent="updateCompania()">
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
                            v-model="compania.activo"
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
                    <label>Localidad</label>
                    <select
                      name="localidad_id"
                      class="form-control form-control"
                      value="localidad_id"
                      v-model="compania.localidad_id"
                    >
                      <option
                        v-for="localidad in localidades"
                        :key="localidad.id"
                        v-bind:value="localidad.id"
                      >{{ localidad.nombre }} / CP:
                        {{ localidad.codigo_postal }}
                      </option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Telefono Oficina</label>
                        <base-input
                          type="text"
                          placeholder="Telefono Oficina"
                          v-model="compania.telefono_1"
                          addon-left-icon="tim-icons icon-mobile"
                        >
                        </base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Telefono Auxilio</label>
                        <base-input
                          type="text"
                          placeholder="Telefono Auxilio"
                          v-model="compania.telefono_aux"
                          addon-left-icon="tim-icons icon-mobile"
                        >
                        </base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Telefono Siniestros</label>
                        <base-input
                          type="text"
                          placeholder="Telefono Siniestros"
                          v-model="compania.telefono_siniestros"
                          addon-left-icon="tim-icons icon-mobile"
                        >
                        </base-input>
                      </div>
                    </div>
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
                >
                  Guardar
                </button>
              </div>

              <!-- ACA EMPIEZA LA TABLA DE CODIGO ORGANIZADOR -->
              <card>
                <div
                  class="col-sm-12"
                  slot="header"
                >
                  <h4 class="d-inline align-bottom text-primary">
                    CODIGOS ORGANIZADOR
                  </h4>
                  <base-button
                    type="primary"
                    size="sm"
                    class="float-right"
                    @click="showModalCodigoOrg"
                  >Crear</base-button>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="codigoOrganizadoresTable">
                      <el-table-column
                        min-width="80"
                        prop="name"
                        label="Apellido"
                        align="left"
                      >
                        <div slot-scope="{ row }">
                          {{ row.organizadores.apellido }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="job"
                        label="Nombre"
                        align="left"
                      >
                        <div slot-scope="{ row }">
                          {{ row.organizadores.nombre }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Matricula"
                      >
                        <div slot-scope="{ row }">
                          {{ row.organizadores.matricula }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="codigo_organizador"
                        align="left"
                        label="Cod. Organizador"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Activo"
                      >
                        <div slot-scope="{ row }">
                          <div v-if="row.activo == true">SI</div>
                          <div v-else>NO</div>
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        header-align="right"
                        align="left"
                        label="Edicion"
                      >
                        <div
                          slot-scope="{ row, $index }"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Refresh"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="
                                handleEdit(props.$nombre, props.row)
                              "
                              :type="$index > 2 ? 'success' : 'neutral'"
                              icon
                              size="sm"
                              class="btn-link"
                            >
                              <i class="tim-icons icon-pencil"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Delete"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="
                                handleDelete(props.$index, props.row)
                              "
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
                  <h4 class="d-inline align-bottom text-primary">
                    CODIGOS PRODUCTOR
                  </h4>
                  <base-button
                    type="primary"
                    size="sm"
                    class="float-right"
                    @click="showModalCodigoPro"
                  >Crear</base-button>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="codigoProductoresTable">
                      <el-table-column
                        min-width="80"
                        label="Apellido"
                        align="left"
                      >
                        <div slot-scope="{ row }">
                          {{ row.productores.apellido }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        label="Nombre"
                        align="left"
                      >
                        <div slot-scope="{ row }">
                          {{ row.productores.nombre }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Matricula"
                      >
                        <div slot-scope="{ row }">
                          {{ row.productores.matricula }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="codigo_productor"
                        align="left"
                        label="Cod. Productor"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="90"
                        align="left"
                        label="Cod. Organizador"
                      >
                        <div slot-scope="{ row }">
                          {{ row.codigo_organizador.codigo_organizador }}
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Activo"
                      >
                        <div slot-scope="{ row }">
                          <div v-if="row.activo == true">SI</div>
                          <div v-else>NO</div>
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        header-align="right"
                        align="left"
                        label="Edicion"
                      >
                        <div
                          slot-scope="{ row, $index }"
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
                              <i class="tim-icons icon-pencil"></i>
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
                  <h4 class="d-inline align-bottom text-primary">COBERTURAS</h4>
                  <base-button
                    type="primary"
                    size="sm"
                    class="float-right"
                    @click="showModalCobertura"
                  >Crear</base-button>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <el-table :data="coberturasTable">
                      <el-table-column
                        min-width="80"
                        prop="nombre"
                        label="Nombre"
                        align="left"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="antiguedad"
                        label="Antiguedad"
                        align="left"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Todo Riesgo"
                      >
                        <div slot-scope="{ row }">
                          <div v-if="row.todo_riesgo == true">SI</div>
                          <div v-else>NO</div>
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="franquicia"
                        align="left"
                        label="Franquicia"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        prop="ajuste"
                        align="left"
                        label="Ajuste"
                      >
                      </el-table-column>
                      <el-table-column
                        min-width="80"
                        align="left"
                        label="Activa"
                      >
                        <div slot-scope="{ row }">
                          <div v-if="row.activo == true">SI</div>
                          <div v-else>NO</div>
                        </div>
                      </el-table-column>
                      <el-table-column
                        min-width="150"
                        header-align="right"
                        align="right"
                        label="Edicion"
                      >
                        <div
                          slot-scope="{ row, $index }"
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
                              <i class="tim-icons icon-pencil"></i>
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
              <modal-coberturas
                v-show="isModalVisibleCobertura"
                @close="closeModalCobertura"
                @crear="crearCobertura"
                :cobertura="cobertura"
              ></modal-coberturas>
              <!-- !ACA TERMINA COBERTURAS -->
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import Fuse from 'fuse.js';
import axios from 'axios';
import swal from 'sweetalert2';
import { BaseAlert } from 'src/components';
import {
  BaseSwitch,
  TagsInput,
  BaseProgress,
  ImageUpload
} from 'src/components/index';
import ModalCoberturas from './Modales/ModalCoberturas';
// import ModalCodigoOrganizadores from './Modales/ModalCodigoOrganizadores';
// import ModalCodigoProductores from './Modales/ModalCodigoProductores';
export default {
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    ImageUpload,
    BaseSwitch
  },
  data() {
    return {
      codigoOrganizadoresTable: [],
      codigoProductoresTable: [],
      coberturasTable: [],
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
      compania: {
        activo: true
      },
      nombreCompania: this.$route.params.nombre,

      localidades: {},
      images: {
        regular: null
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
          console.log(this.compania);
          axios
            .get(
              'http://127.0.0.1:8000/api/codigoorganizador/compania/' +
                this.compania.id
            )
            .then(response => {
              this.codigoOrganizadoresTable = response.data.data;
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
              this.codigoProductoresTable = response.data.data;
            })
            .catch(err => {
              console.log(err);
            });
          axios
            .get(
              'http://127.0.0.1:8000/api/cobertura/compania/' + this.compania.id
            )
            .then(response => {
              this.coberturasTable = response.data.data;
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
          swal({
            title: `Cambios guardados!`,
            // text: 'You clicked the button!',
            buttonsStyling: false,
            confirmButtonClass: 'btn btn-success btn-fill',
            type: 'success'
          });
          console.log('update ok');
          // window.location.replace(
          //   'http://127.0.0.1:8000/administracion/companias/' +
          //     this.compania.nombre +
          //     '/edit'
          // );
        });
    },

    //FIN - FUNCIONES COMPANIA //
    // ----------------------------------------------------------------
    // FUNCIONES CODIGO ORGANIZADOR //
    showModalCodigoOrg() {
      this.vaciarForm();
      this.isModalVisibleCodOrganizador = true;
    },
    closeModalCodigoOrg() {
      this.vaciarForm();
      this.isModalVisibleCodOrganizador = false;
    },
    // ACA PONER LAS FUNCIONES EDITAR Y BORRAR !!!!!!!!!!!!!!!!!!!!!!!!
    // FIN FUNCIONES CODIGO ORGANIZADOR //
    // ----------------------------------------------------------------
    // FUNCIONES CODIGO PRODUCTOR //
    showModalCodigoPro() {
      this.vaciarForm();
      this.isModalVisibleCodProductor = true;
    },
    closeModalCodigoPro() {
      this.vaciarForm();
      this.isModalVisibleCodProductor = false;
    },
    // ACA PONER LAS FUNCIONES EDITAR Y BORRAR !!!!!!!!!!!!!!!!!!!!!!!!
    // FIN FUNCIONES CODIGO PRODUCTOR //
    // ----------------------------------------------------------------
    // FUNCIONES COBERTURA //
    showModalCobertura() {
      this.vaciarForm();
      this.isModalVisibleCobertura = true;
    },
    closeModalCobertura() {
      this.vaciarForm();
      this.isModalVisibleCobertura = false;
    },
    // ACA PONER LAS FUNCIONES EDITAR Y BORRAR !!!!!!!!!!!!!!!!!!!!!!!!
    // FIN FUNCIONES COBERTURA //
    cargarLocalidades() {
      axios.get('http://127.0.0.1:8000/api/localidades').then(response => {
        this.dataLoaded = true;
        this.localidades = response.data.data;
      });
    },
    vaciarForm() {
      this.modoEditar = false;
      this.codigo_organizador = {};
      this.codigo_productor = {};
      this.cobertura = {};
      this.compania.activo = true;
    }
    // cargarOrganizadores() {
    //   axios
    //     .get('http://127.0.0.1:8000/api/administracion/organizadores')
    //     .then(response => {
    //       this.organizadores = response.data.data;
    //     });
    // },
    // cargarProductores() {
    //   axios
    //     .get('http://127.0.0.1:8000/api/administracion/productores')
    //     .then(response => {
    //       this.productores = response.data.data;
    //     });
    // }
  },

  created() {
    this.cargarLocalidades();
    this.cargarCompania();
    // this.cargarCobertura();
  }
};
</script>
