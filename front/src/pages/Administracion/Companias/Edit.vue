<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <div class="row">
          <h4 class="text-primary">EDITAR /</h4>&nbsp;
          <h4 class>{{ compania.nombre }}</h4>
        </div>
      </div>
    </div>
    <form @submit.prevent="actualizar">
      <div>
        <div class="block">
          <div class="block-body">
            <div class="row">
              <div class="col-md-12">
                <card>
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
                      ></base-input>
                      <base-input
                        label="CUIT"
                        type="text"
                        placeholder="Cuit"
                        v-model="compania.cuit"
                        v-validate="modelValidations.cuit"
                        :class="{ 'has-danger': cuitUsed }"
                        :error="getErrorCuit('cuit', cuitUsed)"
                        name="cuit"
                        @keyup="buscarCuit"
                      ></base-input>
                    </div>
                    <div class="col-md-4">
                      <base-input
                        label="Libros Rubricados"
                        type="text"
                        placeholder="Codigo Libros Rubricados"
                        v-model="compania.codigo_lr"
                      ></base-input>
                      <div class="row">
                        <div class="col-md-6">
                          <base-input
                            label="Color Compañia"
                            type="text"
                            placeholder="Color Compañia"
                            v-model="compania.color"
                          ></base-input>
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
                          </base-input>&nbsp;
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>Logo de la Compañia</label>
                      <div class="col-md-4 col-sm-4">
                        <image-upload @change="onImageChange" select-text="Seleccionar Imagen"/>
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
                <card class="stacked-form mb-4">
                  <div class="row">
                    <div class="col-md-4">
                      <base-input
                        label="Direccion"
                        type="text"
                        placeholder="Direccion"
                        v-model="compania.direccion"
                      ></base-input>
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
                        >
                          {{ localidad.nombre }} / CP:
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
                          ></base-input>
                        </div>
                        <div class="col-md-6">
                          <base-input
                            label="Telefono Auxilio"
                            type="text"
                            placeholder="Telefono Auxilio"
                            v-model="compania.telefono_aux"
                          ></base-input>
                        </div>
                        <div class="col-md-6">
                          <base-input
                            type="text"
                            label="Telefono Siniestros"
                            placeholder="Telefono Siniestros"
                            v-model="compania.telefono_siniestros"
                          ></base-input>
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
                      ></base-input>
                      <base-input
                        label="Email Siniestros"
                        placeholder="Email"
                        v-model="compania.email_siniestros"
                        v-validate="modelValidations.email_siniestros"
                        :error="getError('email_siniestros')"
                        name="email_siniestros"
                      ></base-input>
                    </div>
                  </div>
                </card>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-4">
          <button type="submit" class="btn btn-primary ladda-button">Guardar</button>
        </div>
      </div>
    </form>
    <tabla-co v-if="dataLoaded" :compania="compania"/>
    <tabla-cp v-if="dataLoaded" :compania="compania"/>
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
import TablaCp from './CodigoProductor/TablaCp';
import debounce from '../../../debounce.js';

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
    TablaCo,
    TablaCp
  },
  data() {
    return {
      urlcompanias: 'administracion/companias',
      urlCob: 'cobertura/compania',
      urlLocalidades: 'localidades',
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
    onImageChange(file) {
      this.images.regular = file;
    },
    // FUNCIONES COMPANIA //

    cargar() {
      http.loadOne(this.urlcompanias, this.$route.params.nombre).then(r => {
        this.compania = r.data.data[0];
        this.dataLoaded = true;
      });
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed) {
          http
            .update(this.urlcompanias, this.compania.id, this.compania)
            .then(() => {
              EventBus.$emit('resetInput', false);
              this.notifyVue('success', 'La compañia ha sido actualizado');
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
    buscarCuit: debounce(function() {
      if (this.compania.cuit.length == 11) {
        http
          .search('companias/busquedaCuit?q=' + this.compania.cuit)
          .then(r => {
            this.cuit = r.data.data;
            if (this.cuit.length > 0) {
              console.log('usado!');
              this.cuitUsed = true;
              // this.usedError = 'Este CUIT ya esta en uso1';
            } else {
              this.cuitUsed = false;
            }
          });
      }
    }, 500),
    //FIN - FUNCIONES COMPANIA //
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
