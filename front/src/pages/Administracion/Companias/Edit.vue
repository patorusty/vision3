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
    <form @submit.prevent="actualizar">
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
                      v-validate="modelValidations.nombre"
                      :error="getError('nombre')"
                      name="nombre"
                    >
                    </base-input>
                    <base-input
                      label="CUIT"
                      type="text"
                      placeholder="Cuit"
                      v-model="compania.cuit"
                      v-validate="modelValidations.cuit"
                      :class="{ 'has-danger': cuitUsed }"
                      :error="getErrorCuit('cuit', cuitUsed)"
                      name="cuit"
                      @change="buscarCuit"
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
                    <select
                      label="Localidad"
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
                        <base-input
                          label="Telefono Oficina"
                          type="text"
                          placeholder="Telefono Oficina"
                          v-model="compania.telefono_1"
                        >
                        </base-input>
                      </div>
                      <div class="col-md-6">
                        <base-input
                          label="Telefono Auxilio"
                          type="text"
                          placeholder="Telefono Auxilio"
                          v-model="compania.telefono_aux"
                        >
                        </base-input>
                      </div>
                      <div class="col-md-6">
                        <base-input
                          type="text"
                          label="Telefono Siniestros"
                          placeholder="Telefono Siniestros"
                          v-model="compania.telefono_siniestros"
                        >
                        </base-input>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Email Emision"
                      placeholder="Email"
                      v-model="compania.email_emision"
                      v-validate="modelValidations.email_emision"
                      :error="getError('email_emision')"
                      name="email_emision"
                    >
                    </base-input>
                    <base-input
                      label="Email Siniestros"
                      placeholder="Email"
                      v-model="compania.email_siniestros"
                      v-validate="modelValidations.email_siniestros"
                      :error="getError('email_siniestros')"
                      name="email_siniestros"
                    >
                    </base-input>
                  </div>
                </div>
              </card>
              <div class="mb-4">
                <button type="submit" class="btn btn-primary ladda-button">
                  Guardar
                </button>
              </div>

              <tabla-co v-if="dataLoaded" :compania="compania" />
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
                    >Crear</base-button
                  >
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
                          slot-scope="props"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Editar"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="handleEdit(props.row.id)"
                              class="edit btn-link"
                              type="warning"
                              size="sm"
                              icon
                            >
                              <i class="tim-icons icon-pencil"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Eliminar"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="borrarCP(props.row.id)"
                              class="remove btn-link"
                              type="danger"
                              size="sm"
                              icon
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
                    >Crear</base-button
                  >
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
                          slot-scope="props"
                          class="text-right table-actions"
                        >
                          <el-tooltip
                            content="Editar"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="handleEdit(props.row.id)"
                              class="edit btn-link"
                              type="warning"
                              size="sm"
                              icon
                            >
                              <i class="tim-icons icon-pencil"></i>
                            </base-button>
                          </el-tooltip>
                          <el-tooltip
                            content="Eliminar"
                            effect="light"
                            :open-delay="300"
                            placement="top"
                          >
                            <base-button
                              @click.native="borrarCob(props.row.id)"
                              class="remove btn-link"
                              type="danger"
                              size="sm"
                              icon
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
              <!-- <modal-coberturas
                v-show="isModalVisibleCobertura"
                @close="closeModalCobertura"
                @crear="crearCobertura"
                :cobertura="cobertura"
              ></modal-coberturas> -->
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
import { BaseAlert } from 'src/components';
import { BaseSwitch, ImageUpload } from 'src/components/index';
import http from '../../../API/http-request.js';
import { mixin } from '../../../mixins/mixin.js';
import { EventBus } from '../../../main.js';
import TablaCo from './CodigoOrganizador/TablaCo';

export default {
  mixins: [mixin],
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    ImageUpload,
    BaseSwitch,
    BaseAlert,
    BasePagination,
    TablaCo
  },
  data() {
    return {
      urlcompanias: 'administracion/companias',
      // urlCodigoOrg: 'codigoorganizador/compania',
      urlCodigoProd: 'codigoproductor/compania',
      urlCob: 'cobertura/compania',
      urlLocalidades: 'localidades',
      codigoOrganizadoresTable: [],
      codigoProductoresTable: [],
      coberturasTable: [],
      cuitUsed: false,
      usedError: '',
      cuits: [],
      modelValidations: {
        nombre: {
          required: true
        },
        cuit: {
          required: true,
          numeric: true,
          max: 11,
          min: 11
        },
        email_siniestros: {
          email: true
        },
        email_emision: {
          email: true
        }
      },
      compania: {},
      dataLoaded: false,
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

    cargar() {
      http.loadOne(this.urlcompanias, this.$route.params.nombre).then(r => {
        this.compania = r.data.data[0];
        this.dataLoaded = true;
        // http
        //   .loadOne(this.urlCodigoOrg, this.compania.id)
        //   .then(r => {
        //     this.codigoOrganizadoresTable = r.data.data;
        //   })
        //   .catch(err => {
        //     console.log(err);
        //   });
        //   http
        //     .loadOne(this.urlCodigoProd, this.compania.id)
        //     .then(r => {
        //       this.codigoProductoresTable = r.data.data;
        //     })
        //     .catch(err => {
        //       console.log(err);
        //     });
        //   http
        //     .loadOne(this.urlCob, this.compania.id)
        //     .then(r => {
        //       this.coberturasTable = r.data.data;
        //     })
        //     .catch(err => {
        //       console.log(err);
        //     });
      });
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed) {
          http
            .update(this.urlcompanias, this.compania.id, this.compania)
            .then(() => {
              EventBus.$emit('resetInput', false);
              this.notifyVue(
                'success',
                'La compañia ha sido actualizado con exito'
              );
              this.$router.push({
                name: 'Editar Compania',
                params: { nombre: this.compania.nombre }
              });
            });
        }
      });
    },
    getErrorCuit(fieldName, cuitUsed) {
      if (!cuitUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este CUIT ya esta en uso';
      }
    },
    buscarCuit() {
      let query = this.compania.cuit;
      let cuits = [];
      http
        .search('companias/busquedaCuit?q=' + query)
        .then(r => {
          console.log(r);
          cuits = r.data.data;
          if (cuits.length > 0) {
            this.cuitUsed = true;
            this.usedError = 'Este CUIT ya esta en uso';
          } else {
            this.cuitUsed = false;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    //FIN - FUNCIONES COMPANIA //
    // ----------------------------------------------------------------

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
    borrarCP(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete(this.urlCodigoProd, id).then(() => {
            this.notifyVue('danger', 'El codigo productor ha sido eliminado');
            this.cargar();
          });
        }
      });
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
    borrarCob(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete(this.urlCob, id).then(() => {
            this.notifyVue('danger', 'La cobertura ha sido eliminada');
            this.cargar();
          });
        }
      });
    },
    // ACA PONER LAS FUNCIONES EDITAR Y BORRAR !!!!!!!!!!!!!!!!!!!!!!!!
    // FIN FUNCIONES COBERTURA //
    cargarLocalidades() {
      http.load(this.urlLocalidades).then(r => {
        this.localidades = r.data.data;
      });
    },
    vaciarForm() {
      this.modoEditar = false;
      this.codigo_organizador = {};
      this.codigo_productor = {};
      this.cobertura = {};
      this.compania.activo = true;
    }
  },

  created() {
    this.cargarLocalidades();
    this.cargar();
  }
};
</script>
