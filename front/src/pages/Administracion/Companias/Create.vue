<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <h2 class="h5 no-margin-bottom">CREAR COMPAÑIA</h2>
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
              <card class="stacked-form mb-4">
                <div class="row">
                  <div class="col-md-4">
                    <base-input
                      label="Direccion"
                      type="text"
                      placeholder="Direccion"
                      v-model="compania.direccion"
                    >
                    </base-input>

                    <div class="form-group">
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
                    </div>

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
              <div class="">
                <button
                  type="submit"
                  class="btn btn-primary ladda-button"
                > Guardar </button>
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

import {
  BaseProgress,
  BaseSwitch,
  ImageUpload,
  TagsInput
} from 'src/components/index';
export default {
  components: {
    ImageUpload,
    BaseSwitch
  },
  data() {
    return {
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
      localidades: {},
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
    crearCompania() {
      axios
        .post(
          'http://127.0.0.1:8000/api/administracion/companias',
          this.compania
        )
        .then(() => {
          this.compania = {};
          this.compania.activo = true;
          router.push('http://127.0.0.1:8000/administracion/companias');
        })
        .catch(e => console.log(e));
    },
    cargarLocalidades() {
      axios
        .get('http://127.0.0.1:8000/api/localidades')
        .then(function(response) {
          console.log(response.data.data);
          this.localidades = response.data.data;
        });
    }
  },
  created() {
    this.cargarLocalidades();
  }
};
</script>