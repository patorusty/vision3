<template>
  <div class="row">
    <div class="col-md-8">
      <card>
        <h5
          slot="header"
          class="title"
        >Crear Usuario</h5>
        <form @submit.prevent="crearUsuario">
          <div class="row">
            <div class="col-md-6">
              <base-input
                type="text"
                label="Company"
                :disabled="true"
                placeholder="Company"
              >
              </base-input>
            </div>
            <div class="col-md-6">
              <base-input
                type="email"
                label="Email"
                placeholder="mike@email.com"
              >
              </base-input>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <base-input
                type="text"
                label="Nombre"
              >
              </base-input>
            </div>
            <div class="col-md-6">
              <base-input
                type="text"
                label="Apellido"
              >
              </base-input>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <base-input
                type="text"
                label="Tipo Usuario"
              >
              </base-input>
            </div>
            <div class="col-md-4">
              <label>Usuario Activo?</label>
              <base-input>
                <base-switch
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
            <h5 class="title">nombre apellido</h5>
          </a>
          <p class="description">Ceo/Co-Founder</p>
        </div>
        <p></p>
        <div class="card-description">
          Do not be scared of the truth because we need to restart the human
          foundation in truth And I love you like Kanye loves Kanye I love Rick
          Owens’ bed design but the back is...
        </div>
      </card>
    </div>
  </div>
</template>
<script>
import { BaseSwitch, ImageUpload } from 'src/components/index';
import http from '../../../API/http-request.js';
import debounce from '../../../debounce.js';
export default {
  components: {
    BaseSwitch,
    ImageUpload
  },
  data() {
    return {
      images: {
        avatar: null
      }
    };
  },
  methods: {
    onAvatarChange(file) {
      this.images.avatar = file;
    }
  }
};
</script>
<style></style>