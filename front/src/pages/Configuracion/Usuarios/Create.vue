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
              </div>
              <div class="col-md-6">
                <base-input
                  type="email"
                  label="Email"
                  placeholder="mike@email.com"
                  v-model="usuario.email"
                >
                </base-input>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <base-input
                  type="text"
                  label="Nombre"
                  v-model="usuario.nombre"
                >
                </base-input>
              </div>
              <div class="col-md-6">
                <base-input
                  type="text"
                  label="Apellido"
                  v-model="usuario.apellido"
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
                  value="tipo_usuario_id"
                  v-model="usuario.tipo_usuario"
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
            <div class="row">
              <div class="col-md-12">
                <base-input label="Sobre Mi">
                  <textarea
                    rows="1"
                    class="form-control"
                    placeholder="Sobre Mi"
                    v-model="usuario.aboutme"
                  >
            </textarea>
                </base-input>
              </div>
            </div>
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
  components: {
    mixins: [mixin],
    BaseSwitch,
    ImageUpload,
    [Select.name]: Select,
    [Option.name]: Option,
    [DatePicker.name]: DatePicker
  },
  data() {
    return {
      usuario: {
        activo: true,
        compania: 'Vision',
        password: '123'
      },
      images: {
        avatar: null
      },
      tipo_usuarios: {}
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
      http
        .create('configuracion/usuarios', this.usuario)
        .then(() => {
          this.notifyVue('success', 'El usuario ha sido creado con exito');
          this.$router.push({ name: 'Usuarios' });
        })
        .catch(e => console.log(e));
    }
  },
  created() {
    this.cargarTipo_Usuarios();
  }
};
</script>
<style></style>