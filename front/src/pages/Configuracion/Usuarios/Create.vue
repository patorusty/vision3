<template>
  <div>
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <div class="row">
          <h4 class="text-primary pl-3">CREAR USUARIO</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <card>
          <form @submit.prevent="crearUsuario">
            <div class="row">
              <div class="col-md-6">
                <base-input
                  type="text"
                  label="Company"
                  :disabled="true"
                  v-model="usuario.compania"
                >
                </base-input>
                <base-input
                  type="text"
                  label="Nombre"
                  v-model="usuario.nombre"
                  v-validate="'required'"
                  :error="getError('nombre')"
                  name="nombre"
                >
                </base-input>

              </div>
              <div class="col-md-6">
                <base-input
                  type="email"
                  label="Email"
                  placeholder="mike@email.com"
                  v-model="usuario.email"
                  v-validate="'required'"
                  :error="getErrorMail('email', mailUsed)"
                  name="email"
                  @keyup="buscarMail"
                  :class="{ 'has-danger': mailUsed }"
                >
                </base-input>
                <base-input
                  type="text"
                  label="Apellido"
                  v-model="usuario.apellido"
                  v-validate="'required'"
                  :error="getError('apellido')"
                  name="apellido"
                >
                </base-input>

              </div>

            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Tipo Usuario</label>
                <el-select
                  filterable
                  class="select-primary"
                  :class="{ errorS: errorSelect.tipo_usuario }"
                  value="tipo_usuario_id"
                  v-model="usuario.tipo_usuario_id"
                  @change="touchSelect('tipo_usuario')"
                >
                  <el-option
                    v-for="tipo_usuario in tipo_usuarios"
                    class="select-primary"
                    :key="tipo_usuario.id"
                    :value="tipo_usuario.id"
                    :label="tipo_usuario.nombre"
                  >
                    {{ tipo_usuario.nombre }}
                  </el-option>
                </el-select>
                <p
                  class="errorSelect"
                  v-show="errorSelect.tipo_usuario"
                >
                  Debe seleccionar un Tipo de Usuario
                </p>
              </div>
              <div class="col-md-4">
                <label>Usuario Activo?</label>
                <base-input>
                  <base-switch
                    v-model="usuario.activo"
                    type="primary"
                    on-text="ON"
                    off-text="OFF"
                  ></base-switch>
                </base-input>
              </div>
              <div class="col-md-4">
                <h4 class="card-title">Avatar</h4>
                <image-upload
                  type="avatar"
                  select-text="Subir Avatar"
                  @change="onAvatarChange"
                />
              </div>
            </div>
            <div class="row"></div>
            <base-button
              native-type="submit"
              type="primary"
              class="btn-fill"
            >
              Crear
            </base-button>
          </form>
        </card>
      </div>
      <div class="col-md-4">
        <card class="card-user">
          <p class="card-text"></p>
          <div class="author">
            <div class="block block-one"></div>
            <div class="block block-two"></div>
            <div class="block block-three"></div>
            <div class="block block-four"></div>
            <a href="javascript:void(0)">
              <img
                class="avatar"
                src="img/emilyz.jpg"
                alt="."
              />
            </a>
          </div>
        </card>
      </div>
    </div>
  </div>
</template>
<script>
import { Select, Option, DatePicker } from 'element-ui';
import { BaseSwitch, ImageUpload } from 'src/components/index';
import http from '../../../API/http-request.js';
import debounce from '../../../debounce.js';
import { mixin } from '../../../mixins/mixin.js';

export default {
  mixins: [mixin],
  components: {
    BaseSwitch,
    ImageUpload,
    [Select.name]: Select,
    [Option.name]: Option,
    [DatePicker.name]: DatePicker
  },
  data() {
    return {
      mailUsed: false,
      mail: '',
      errorSelect: {
        tipo_usuario: false
      },
      selected: {
        tipo_usuario: false
      },
      usuario: {
        activo: true,
        compania: 'Vision',
        password: '123'
      },
      images: {
        avatar: null
      },
      tipo_usuarios: {},
      tipo_usuario: ''
    };
  },
  methods: {
    onAvatarChange(file) {
      this.images.avatar = file;
    },
    cargarTipo_Usuarios() {
      http.load('tipousuario').then(response => {
        this.tipo_usuarios = response.data.data;
      });
    },
    crearUsuario() {
      this.$validator.validateAll().then(r => {
        if (this.checkSelect() && r && !this.mailUsed) {
          http
            .create('configuracion/usuarios', this.usuario)
            .then(() => {
              this.notifyVue(
                'success',
                'El usuario ha sido modificado con exito'
              );
              this.$router.push({
                name: 'Usuarios'
              });
            })

            .catch(e => console.log(e));
        }
      });
    },
    touchSelect(val) {
      this.selected[val] = true;
      this.errorSelect[val] = false;
    },
    getErrorMail(fieldName, mailUsed) {
      if (!mailUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este mail ya esta en uso';
      }
    },
    buscarMail: debounce(function() {
      if (this.usuario.email) {
        http.search('usuario/busquedaMail?q=' + this.usuario.email).then(r => {
          this.mail = r.data.data;
          if (this.mail.length > 0) {
            console.log('usado!');
            this.mailUsed = true;
          } else {
            this.mailUsed = false;
          }
        });
      }
    }, 1000)
  },
  created() {
    this.cargarTipo_Usuarios();
  }
};
</script>
<style></style>
