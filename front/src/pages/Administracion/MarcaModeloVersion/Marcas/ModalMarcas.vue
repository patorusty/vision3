<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop style="width:25%;">
        <card>
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Marca</h4>
              <button
                class="close"
                type="button"
                aria-label="Close"
                @click="close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-contenido">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <base-input
                      placeholder="Nombre de la Marca"
                      v-model="marca.nombre"
                      name="nombre"
                      v-validate="'required'"
                      :class="{ 'has-danger': marcaUsed }"
                      :error="getErrorMarca('nombre', marcaUsed)"
                      @keyup="buscarMarca"
                    ></base-input>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-pie pull-right mt-3">
              <base-button
                v-if="modo == true"
                class="btn btn-primary ladda-button"
                type="submit"
                @click="actualizar"
                >Guardar</base-button
              >
              <base-button
                v-else
                class="btn btn-primary ladda-button"
                type="submit"
                @click="crear"
                >Crear</base-button
              >
            </div>
          </form>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import debounce from '../../../../debounce.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['marca', 'modo'],
  name: 'modal-marcas',
  mixins: [mixin],
  data() {
    return {
      url: 'administracion/marcas',
      nombreDeMarca: '',
      marcaUsed: false,
      usedError: ''
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    [Option.name]: Option
  },
  methods: {
    close() {
      this.$emit('close');
      this.$validator.reset();
      this.errors.clear();
      this.marcaUsed = false;
      this.usedError = '';
      EventBus.$emit('resetInput', false);
    },
    crear() {
      this.$validator.validateAll().then(r => {
        if (r && !this.marcaUsed) {
          this.$emit('crear', this.marca);
          this.$validator.reset();
          this.errors.clear();
        }
      });
    },

    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.marcaUsed) {
          http
            .update(this.url, this.marca.id, this.marca)
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'La Marca ha sido actualizado con exito'
              );
            })
            .catch(e => console.log(e));
        }
      });
    },
    buscarMarca: debounce(function() {
      if (this.marca.nombre) {
        http.search('marcas/busquedaMarca?q=' + this.marca.nombre).then(r => {
          this.nombreDeMarca = r.data.data;
          if (this.nombreDeMarca.length > 0) {
            this.marcaUsed = true;
          } else {
            this.marcaUsed = false;
          }
        });
      }
    }, 500),
    getErrorMarca(fieldName, marcaUsed) {
      if (!marcaUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Esta marca ya existe';
      }
    }
  }
};
</script>
<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
}
.div-stop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}
.el-select {
  display: block;
}
.errorSelect {
  color: #ec250d !important;
  font-size: 0.75rem;
  margin-bottom: 5px;
  margin-top: 5px;
}
</style>
