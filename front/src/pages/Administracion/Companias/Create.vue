<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <h4 class="text-primary">CREAR COMPAÑIA</h4>
      </div>
    </div>
    <form @submit.prevent="crearCompania">
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
                      label="CUIT"
                      type="text"
                      v-validate="modelValidations.cuit"
                      v-model.lazy="compania.cuit"
                      :class="{ 'has-danger': cuitUsed }"
                      :error="getError('cuit', cuitUsed)"
                      name="cuit"
                      @keyup="buscarCuit"
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
import { BaseSwitch, ImageUpload } from 'src/components/index';
import http from '../../../API/http-request.js';
import debounce from '../../../debounce.js';
export default {
  components: {
    ImageUpload,
    BaseSwitch
  },
  data() {
    return {
      cuitUsed: false,
      cuit: '',
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
    getError(fieldName, cuitUsed) {
      if (!cuitUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este CUIT ya esta en uso';
      }
    },
    crearCompania() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed) {
          http
            .create('administracion/companias', this.compania)
            .then(() => {
              this.compania = {};
              this.$router.push({ name: 'Companias' });
            })
            .catch(e => console.log(e));
        } else {
          console.log(this.errors);
        }
      });
    },
    onImageChange(file) {
      this.images.regular = file;
    },
    cargarLocalidades() {
      http.load('localidades').then(response => {
        this.localidades = response.data.data;
      });
    },
    buscarCuit: debounce(function() {
      if (this.compania.cuit.length == 11) {
        http
          .search('companias/busquedaCuit?q=' + this.compania.cuit)
          .then(r => {
            this.cuit = r.data.data;
            if (this.cuit.length > 0) {
              this.cuitUsed = true;
            } else {
              this.cuitUsed = false;
            }
          });
      }
    }, 1000)
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
