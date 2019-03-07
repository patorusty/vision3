<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <h4 class="text-primary">CREAR COMPAÑIA</h4>
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
                      v-model="compania.nombre"
                      v-validate="modelValidations.nombre"
                      :error="getError('nombre')"
                      name="nombre"
                    ></base-input>
                    <base-input
                      label="Cuit"
                      type="text"
                      v-validate="modelValidations.cuit"
                      v-model="compania.cuit"
                      :class="{ 'has-danger': used }"
                      :error="getError('cuit', used)"
                      name="cuit"
                      @keydown.tab="buscarCuit"
                    ></base-input>
                  </div>
                  <div class="col-md-4">
                    <base-input
                      label="Libros Rubricados"
                      type="text"
                      v-model="compania.codigo_lr"
                    ></base-input>
                    <div class="row">
                      <div class="col-md-6">
                        <base-input
                          label="Color Compañia"
                          type="text"
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
                          ></base-switch> </base-input
                        >&nbsp;
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
              <card class="stacked-form mb-4">
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Direccion"
                      type="text"
                      v-model="compania.direccion"
                    ></base-input>

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
                      >
                        {{ localidad.nombre }} / CP:
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
                          v-model="compania.telefono_1"
                          addon-left-icon="tim-icons icon-mobile"
                        ></base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Telefono Auxilio</label>
                        <base-input
                          type="text"
                          v-model="compania.telefono_aux"
                          addon-left-icon="tim-icons icon-mobile"
                        ></base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Telefono Siniestros</label>
                        <base-input
                          type="text"
                          v-model="compania.telefono_siniestros"
                          addon-left-icon="tim-icons icon-mobile"
                        ></base-input>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Email Emision</label>
                    <base-input
                      required
                      v-model="compania.email_emision"
                      addon-left-icon="tim-icons icon-email-85"
                    ></base-input>
                    <label>Email Siniestros</label>
                    <base-input
                      required
                      v-model="compania.email_siniestros"
                      addon-left-icon="tim-icons icon-email-85"
                    ></base-input>
                  </div>
                </div>
              </card>
              <div class>
                <button type="submit" class="btn btn-primary ladda-button">
                  Crear
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import axios from 'axios';

import { BaseSwitch, ImageUpload } from 'src/components/index';
export default {
  components: {
    ImageUpload,
    BaseSwitch
  },
  data() {
    return {
      used: false,
      usedError: '',
      modelValidations: {
        nombre: {
          required: true
        },
        cuit: {
          required: true,
          numeric: true,
          max: 11,
          min: 11
        }
      },

      compania: {
        activo: true
      },
      localidades: {},
      images: {
        regular: null
      }
    };
  },
  methods: {
    getError(fieldName, used = false) {
      if (!used) {
        return this.errors.first(fieldName);
      } else {
        return 'Este CUIT ya esta en uso';
      }
    },
    validate() {
      this.$validator.validateAll().then(isValid => {
        this.$emit('on-submit', this.registerForm, isValid);
      });
    },
    onImageChange(file) {
      this.images.regular = file;
    },
    crearCompania() {
      if (this.errors.items.length == 0) {
        axios
          .post(
            'http://127.0.0.1:8000/api/administracion/companias',
            this.compania
          )
          .then(() => {
            this.compania = {};
            // this.compania.activo = true;
            this.$router.push({ name: 'Companias' });
          })
          .catch(e => console.log(e));
      } else {
        console.log(this.errors);
      }
    },
    cargarLocalidades() {
      axios.get('http://127.0.0.1:8000/api/localidades').then(response => {
        this.dataLoaded = true;
        this.localidades = response.data.data;
      });
    },
    buscarCuit() {
      let query = this.compania.cuit;
      let cuits = [];
      // console.log(query);
      axios
        .get('http://127.0.0.1:8000/api/companias/busquedaCuit?q=' + query)
        .then(response => {
          // console.log(response.data.data);
          cuits = response.data.data;
          // console.log(cuits);
          if (cuits.length > 0) {
            this.used = true;
            this.usedError = 'Este CUIT ya esta en uso';
          } else {
            this.used = false;
          }
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  created() {
    this.cargarLocalidades();
  }
};
</script>
<style>
.errorInput {
  color: #ec250d;
  font-size: 0.75rem;
  margin-bottom: 5px;
}
</style>
