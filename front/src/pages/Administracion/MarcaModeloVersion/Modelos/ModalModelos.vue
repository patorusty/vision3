<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @keydown.esc="close"
      @click="close"
    >
      <div
        @click.stop
        style="width:25%;"
      >
        <card>
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Modelo</h4>
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
                    <el-select
                      class="select-primary"
                      placeholder="Seleccionar Marca"
                      v-model="modelo.automotor_marca_id"
                      name="modelo.marca_id"
                      @change="touchSelect"
                      filterable
                    >
                      <el-option
                        v-for="marca in marcas"
                        :key="marca.id"
                        :value="marca.id"
                        :label="marca.nombre"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect"
                    >Debe seleccionar una marca</p>
                  </div>
                  <div class="mb-3">
                    <base-input
                      placeholder="Nombre del Modelo"
                      v-model="modelo.nombre"
                      name="nombre"
                      v-validate="'required'"
                      :class="{ 'has-danger': modeloUsed }"
                      :error="getErrorModelo('nombre', modeloUsed)"
                      @keyup="buscarModelo"
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
              >Guardar</base-button>
              <base-button
                v-else
                class="btn btn-primary ladda-button"
                type="submit"
                @click="crear"
              >Crear</base-button>
            </div>
          </form>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Select, Option } from 'element-ui';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import debounce from '../../../../debounce.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['modelo', 'modo'],
  name: 'modal-modelos',
  mixins: [mixin],
  data() {
    return {
      url: 'administracion/modelos',
      nombreDeModelo: '',
      modeloUsed: false,
      usedError: '',
      marcas: [],
      errorSelect: false,
      selected: false
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    [Option.name]: Option,
    [Select.name]: Select
  },
  methods: {
    close() {
      this.$emit('close');
      this.$validator.reset();
      this.errors.clear();
      this.modeloUsed = false;
      this.usedError = '';
      this.selected = false;
      this.errorSelect = false;
      EventBus.$emit('resetInput', false);
    },
    crear() {
      if (!this.selected && this.$validator.validateAll().then(r => r)) {
        this.errorSelect = true;
      } else {
        this.$validator.validateAll().then(r => {
          if (r && !this.modeloUsed) {
            this.$emit('crear', this.modelo);
            this.$validator.reset();
            this.errors.clear();
          }
        });
      }
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.modeloUsed) {
          http
            .update(this.url, this.modelo.id, this.modelo)
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'El Modelo ha sido actualizado con exito'
              );
            })
            .catch(e => console.log(e));
        }
      });
    },
    buscarModelo: debounce(function() {
      if (this.modelo.nombre) {
        http.search('modelo/busquedaModelo?q=' + this.modelo.nombre).then(r => {
          this.nombreDeModelo = r.data.data;
          if (this.nombreDeModelo.length > 0) {
            this.modeloUsed = true;
          } else {
            this.modeloUsed = false;
          }
        });
      }
    }, 500),
    getErrorModelo(fieldName, modeloUsed) {
      if (!modeloUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este modelo ya existe';
      }
    },
    cargarMarcas() {
      http.load('administracion/marcas', this.marca_id).then(r => {
        this.marcas = r.data.data;
      });
    },
    touchSelect() {
      this.selected = true;
      this.errorSelect = false;
    }
  },
  created() {
    this.cargarMarcas();
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
