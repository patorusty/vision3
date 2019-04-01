<template>
  <div class="container-fluid">
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <div class="row">
          <h4 class="text-primary">CREAR CLIENTE</h4>
          &nbsp;
        </div>
      </div>
    </div>
    <form>
      <div>
        <div class="block">
          <div class="block-body">
            <div class="row">
              <div class="col-md-12">
                <card>
                  <div class="row">
                    <div class="col-md-3 ml-0 mb-3">
                      <el-select
                        class="select-primary"
                        placeholder="Tipo de Persona"
                        v-model="cliente.tipo_persona"
                      >
                        <el-option
                          v-for="option in selectOptions"
                          :key="option.value"
                          :label="option.label"
                          :value="option.value"
                          class="select-primary"
                        ></el-option>
                      </el-select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p class="card-title">DATOS PERSONALES</p>
                    </div>
                  </div>
                  <div class="row">
                    <div
                      class="col-md-4"
                      v-if="cliente.tipo_persona === 'Persona Juridica'"
                    >
                      <base-input
                        label="Razon Social"
                        type="text"
                        placeholder="Razon Social"
                        v-model="cliente.razon_social"
                        v-validate="validations.razon_social"
                        :error="getError('razon_social')"
                        name="razon_social"
                      ></base-input>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <base-input
                        label="Nombre"
                        type="text"
                        placeholder="Nombre"
                        v-model="cliente.nombre"
                        v-validate="validations.nombre"
                        :error="getError('nombre')"
                        name="nombre"
                      ></base-input>
                    </div>
                    <div class="col-md-4">
                      <base-input
                        label="Apellido"
                        type="text"
                        placeholder="Apellido"
                        v-model="cliente.apellido"
                        v-validate="validations.apellido"
                        :error="getError('apellido')"
                        name="apellido"
                      ></base-input>
                    </div>
                    <div
                      class="col-md-4"
                      v-if="cliente.tipo_persona === 'Persona Fisica'"
                    >
                      <base-input
                        label="DNI"
                        type="text"
                        placeholder="DNI"
                        v-model="cliente.nro_dni"
                        v-validate="validations.nro_dni"
                        :error="getErrorDNI('nro_dni', dniUsed)"
                        :class="{ 'has-danger': dniUsed }"
                        name="nro_dni"
                        @keyup="buscarDNI"
                      ></base-input>
                    </div>
                    <div
                      class="col-md-4"
                      v-if="cliente.tipo_persona === 'Persona Juridica'"
                    >
                      <base-input
                        label="CUIT"
                        type="text"
                        placeholder="CUIT"
                        v-model="cliente.cuit"
                        v-validate="validations.cuit"
                        :class="{ 'has-danger': cuitUsed }"
                        :error="getErrorCuit('cuit', cuitUsed)"
                        name="cuit"
                        @keyup="buscarCuit"
                      ></base-input>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label>Sexo</label>
                      <div class="d-flex flex-row">
                        <base-radio class="mr-5" v-model="cliente.sexo" name="M"
                          >Masculino</base-radio
                        >
                        <base-radio v-model="cliente.sexo" name="F"
                          >Femenino</base-radio
                        >
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label>Fecha de Nacimiento</label>
                      <base-input>
                        <el-date-picker
                          v-model="cliente.nacimiento"
                          type="date"
                          placeholder="Fecha de Nacimiento"
                          format="d/M/yyyy"
                          value-format="yyyy-MM-dd"
                          @change="touchSelect('nacimiento')"
                        ></el-date-picker>
                        <p class="errorSelect" v-show="errorSelect1">
                          Este campo es obligatorio
                        </p>
                      </base-input>
                    </div>
                    <div class="col-md-4">
                      <base-input
                        label="Email"
                        type="text"
                        placeholder="Email"
                        v-model="cliente.email"
                        v-validate="validations.email"
                        :error="getError('email')"
                        name="email"
                      ></base-input>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <base-input
                        label="Email Alternativo"
                        type="text"
                        placeholder="Email Alternativo"
                        v-model="cliente.email_alt"
                        v-validate="validations.email_alt"
                        :error="getError('email_alt')"
                        name="email_alt"
                      ></base-input>
                    </div>
                    <div class="col-md-8">
                      <base-input label="Observaciones">
                        <textarea
                          class="form-control"
                          v-model="cliente.observaciones_1"
                        ></textarea>
                      </base-input>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <p class="card-title">DIRECCION</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5">
                      <base-input
                        label="Calle"
                        type="text"
                        placeholder="Calle"
                        v-model="cliente.direccion"
                        v-validate="validations.direccion"
                        :error="getError('direccion')"
                        name="direccion"
                      ></base-input>
                    </div>
                    <div class="col-md-3">
                      <base-input
                        label="Numero"
                        type="text"
                        placeholder="numero"
                        v-model="cliente.direccion_nro"
                        :error="getError('direccion_nro')"
                        name="direccion_nro"
                      ></base-input>
                    </div>
                    <div class="col-md-2">
                      <base-input
                        label="Piso"
                        type="text"
                        placeholder="Piso"
                        name="direccion_piso"
                      ></base-input>
                    </div>
                    <div class="col-md-2">
                      <base-input
                        label="Depto"
                        type="text"
                        placeholder="Depto"
                        name="direccion_depto"
                      ></base-input>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <label>Localidad y CP</label>
                      <el-select
                        filterable
                        class="select-primary"
                        placeholder="Selecciones Localidad"
                        v-model="cliente.localidad_id"
                        name="localidad_id"
                        @change="touchSelect('localidad')"
                      >
                        <el-option
                          v-for="localidad in localidades"
                          :key="localidad.id"
                          :value="localidad.id"
                          :label="
                            localidad.nombre +
                              '/ CP: ' +
                              localidad.codigo_postal
                          "
                          class="select-primary"
                        ></el-option>
                      </el-select>
                      <p class="errorSelect" v-show="errorSelect2">
                        Este campo es obligatorio
                      </p>
                    </div>
                    <div class="col-md-5">
                      <base-input
                        label="Country / Barrio Cerrado"
                        type="text"
                        placeholder="Country / Barrio Cerrado"
                        name="barrio_cerrado"
                      ></base-input>
                    </div>
                    <div class="col-md-3">
                      <base-input
                        label="Lote"
                        type="text"
                        placeholder="Lote"
                        name="lote"
                      ></base-input>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <p class="card-title">TELEFONOS</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <base-input
                        label="Celular"
                        type="text"
                        placeholder="Celular"
                        v-model="cliente.celular"
                        :error="getError('celular')"
                        name="celular"
                      ></base-input>
                    </div>
                    <div class="col-md-4">
                      <base-input
                        label="Telefono"
                        type="text"
                        placeholder="Telefono"
                        v-model="cliente.telefono_1"
                        :error="getError('telefono_1')"
                        name="telefono_1"
                      ></base-input>
                    </div>
                    <div class="col-md-4">
                      <base-input
                        label="Telefono Alternativo"
                        type="text"
                        placeholder="Telefono Alternativo"
                        v-model="cliente.telefono_2"
                        :error="getError('telefono_2')"
                        name="telefono_2"
                      ></base-input>
                    </div>
                    <div class="col-md-12">
                      <base-input label="Observaciones">
                        <textarea
                          class="form-control"
                          v-model="cliente.observaciones_1_2"
                        ></textarea>
                      </base-input>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-4">
                      <p class="card-title">PRODUCTOR</p>
                      <el-select
                        class="select-primary pl-0 col-md-12"
                        placeholder="Seleccionar Productor"
                        v-model="cliente.productor_id"
                        name="productor_id"
                        @change="touchSelect('productor')"
                      >
                        <el-option
                          v-for="productor in productores"
                          :key="productor.id"
                          :value="productor.id"
                          :label="
                            productor.apellido +
                              ' ' +
                              productor.nombre +
                              ' (Matricula: ' +
                              productor.matricula +
                              ')'
                          "
                          class="select-primary"
                        ></el-option>
                      </el-select>
                      <p class="errorSelect" v-show="errorSelect3">
                        Debe seleccionar un Productor
                      </p>
                    </div>
                    <div class="col-md-8 d-flex flex-column">
                      <p class="card-title">REGISTRO</p>
                      <div class="row">
                        <div class="col-md-4">
                          <base-input
                            type="text"
                            placeholder="Numero"
                            v-model="cliente.registro"
                            :error="getError('registro')"
                            name="registro"
                          ></base-input>
                        </div>
                        <div class="col-md-4">
                          <base-input>
                            <el-date-picker
                              v-model="cliente.vencimiento_registro"
                              type="date"
                              placeholder="Fecha de Vencimiento"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                          <image-upload select-text="Subir Registro" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col-md-4">
                      <base-button
                        class="animation-on-hover pull-left"
                        type="primary"
                        >Crear</base-button
                      >
                    </div>
                  </div>
                </card>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { Select, Option, DatePicker } from 'element-ui';
import { mixin } from '../../mixins/mixin.js';
import http from '../../API/http-request.js';
import debounce from '../../debounce.js';
import { BaseRadio, ImageUpload } from 'src/components/index';

export default {
  mixins: [mixin],
  components: {
    [DatePicker.name]: DatePicker,
    [Option.name]: Option,
    [Select.name]: Select,
    BaseRadio,
    ImageUpload
  },
  data: () => ({
    selectOptions: [
      {
        value: 'Persona Fisica',
        label: 'Persona Fisica'
      },
      {
        value: 'Persona Juridica',
        labe: 'Persona Juridica'
      }
    ],
    cuitUsed: false,
    dniUsed: false,
    selected1: false,
    errorSelect: {
      nacimiento: false,
      localidad: false,
      productor: false
    },
    selected: {
      nacimiento: false,
      localidad: false,
      productor: false
    },
    errorSelect1: false,
    selected2: false,
    errorSelect2: false,
    selected3: false,
    errorSelect3: false,
    dni: '',
    cuit: '',
    localidades: [],
    productores: [],
    cliente: {
      tipo_persona: 'Persona Fisica',
      sexo: 'M'
    },
    validations: {
      nombre: {
        required: true
      },
      apellido: {
        required: true
      },
      nro_dni: {
        required: true,
        numeric: true
      },
      cuit: {
        required: true,
        numeric: true,
        max: 11,
        min: 11
      },
      email: {
        email: true
      },
      email_alt: {
        email: true
      },
      direccion: {
        required: true
      },
      direccion_nro: {
        required: true
      },
      celular: {
        required: true
      }
    }
  }),
  methods: {
    getErrorCuit(fieldName, cuitUsed) {
      if (!cuitUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este CUIT ya esta en uso';
      }
    },
    buscarCuit: debounce(function() {
      if (this.cliente.cuit.length == 11) {
        http.search('cliente/busquedaCuit?q=' + this.cliente.cuit).then(r => {
          this.cuit = r.data.data;
          if (this.cuit.length > 0) {
            this.cuitUsed = true;
          } else {
            this.cuitUsed = false;
          }
        });
      }
    }, 500),
    getErrorDNI(fieldName, dniUsed) {
      if (!dniUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este DNI ya esta en uso';
      }
    },
    buscarDNI: debounce(function() {
      if (this.cliente.nro_dni.length >= 6) {
        http.search('cliente/busquedaDNI?q=' + this.cliente.nro_dni).then(r => {
          this.dni = r.data.data;
          if (this.dni.length > 0) {
            console.log('usado!');
            this.dniUsed = true;
          } else {
            this.dniUsed = false;
          }
        });
      }
    }, 500),
    cargarLocalidades() {
      http.load('localidades').then(r => {
        this.localidades = r.data.data;
      });
    },
    cargarProductores() {
      http
        .load('administracion/productores')
        .then(r => (this.productores = r.data.data));
    },
    touchSelect(val) {
      console.log(val);
      return (this.selected[val] = true);
      console.log()
    },
    crear() {
      if (
        !this.selected1 &&
        !this.selected2 &&
        !this.selected3 &&
        this.$validator.validateAll().then(r => r)
      ) {
        this.errorSelect1 = true;
        this.errorSelect2 = true;
        this.errorSelect3 = true;
      } else if (
        this.selected1 &&
        !this.selected2 &&
        this.$validator.validateAll().then(r => r)
      ) {
        this.errorSelect2 = true;
      } else if (
        !this.selected1 &&
        this.selected2 &&
        this.$validator.validateAll().then(r => r)
      ) {
        this.errorSelect1 = true;
      } else {
        this.$validator.validateAll().then(r => {
          if (r && !this.CPUsed && this.CP <= 0) {
            this.$emit('crear', this.codigo_productor);
            this.$validator.reset();
            this.errors.clear();
            this.selected1 = false;
            this.selected2 = false;
          }
        });
      }
    }
  },
  created() {
    this.cargarLocalidades();
    this.cargarProductores();
  }
};
</script>
<style>
textarea.form-control {
  line-height: 1;
}
</style>
