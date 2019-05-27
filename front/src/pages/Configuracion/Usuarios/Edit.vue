<template>
  <div>
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <div class="row">
          <h4 class="text-primary pl-3">EDITAR USUARIO</h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
        <card>
          <form>
            <div class="row">
              <div class="col-md-6">
                <base-input
                  type="text"
                  label="Company"
                  :disabled="true"
                  placeholder="Company"
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
                  v-model="usuario.tipo_usuario_id"
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
                    type="primary"
                    on-text="ON"
                    off-text="OFF"
                    v-model="usuario.activo"
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
            </div>
            <base-button
              type="primary"
              class="btn-fill"
              @click="actualizar"
            >
              Guardar
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
                alt="..."
              />
              <h5 class="title">{{usuario.nombre}} {{usuario.apellido}}</h5>
            </a>
            <p class="description"> {{ tipo_usuarios.nombre }}
            </p>
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
import { EventBus } from '../../../main.js';

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
      images: {
        avatar: null
      },
      usuario: {},
      tipo_usuarios: []
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
    cargar() {
      http.loadOne('configuracion/usuarios', this.$route.params.id).then(r => {
        this.usuario = r.data.data;
      });
    },
    actualizar() {
      http
        .update('configuracion/usuarios', this.usuario.id, this.usuario)
        .then(() => {
          this.notifyVue('success', 'El usuario ha sido modificado con exito');
        });
    }
  },
  created() {
    this.cargar();
    this.cargarTipo_Usuarios();
  }
};
</script>
<style></style>