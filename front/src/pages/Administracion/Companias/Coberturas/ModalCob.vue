<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop style="width:35%;">
        <card>
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Cobertura</h4>
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
                      placeholder="Nombre de la Cobertura"
                      type="text"
                      v-model="cobertura.nombre"
                      v-validate="'required'"
                      :error="getError('nombre')"
                      name="nombre"
                    ></base-input>
                    <div class="row">
                      <div class="col-md-6">
                        <p class="category">Todo Riesgo?</p>
                        <base-switch
                          v-model="cobertura.todo_riesgo"
                          type="primary"
                          on-text="SI"
                          off-text="NO"
                        ></base-switch>
                      </div>
                      <div class="col-md-6">
                        <div v-if="!cobertura.todo_riesgo">
                          <base-input
                            placeholder="Franquicia"
                            type="text"
                            name="franquicia"
                            v-model="cobertura.franquicia"
                            disabled
                          ></base-input>
                        </div>
                        <div v-else>
                          <base-input
                            placeholder="Franquicia"
                            type="text"
                            name="franquicia"
                            v-model="cobertura.franquicia"
                          ></base-input>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <base-input
                          placeholder="Antiguedad en Años"
                          type="number"
                          name="antiguedad"
                          v-model="cobertura.antiguedad"
                        ></base-input>
                      </div>
                      <div class="col-md-6">
                        <el-select
                          placeholder="Ajuste"
                          class="select-primary"
                          v-model="cobertura.ajuste"
                          name="ajuste"
                          :class="{ errorS: errorSelect }"
                          @change="touchSelect"
                        >
                          <el-option
                            v-for="ajuste in ajustes"
                            :key="ajuste"
                            :value="ajuste"
                            :label="ajuste"
                          >
                          </el-option>
                        </el-select>
                        <p class="errorSelect" v-show="errorSelect">
                          Debe seleccionar un ajuste
                        </p>
                      </div>
                    </div>
                    <base-input label="Detalle">
                      <textarea
                        class="form-control"
                        v-model="cobertura.detalle"
                      ></textarea>
                    </base-input>
                    <p class="category">Activo?</p>
                    <base-switch
                      v-model="cobertura.activa"
                      type="primary"
                      on-text="ON"
                      off-text="OFF"
                    ></base-switch>
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
import { Select, Option } from 'element-ui';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import { BaseSwitch } from 'src/components/index';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
// import debounce from '../../../../debounce.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['cobertura', 'modo'],
  name: 'modal-cob',
  mixins: [mixin],
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch,
    [Option.name]: Option,
    [Select.name]: Select
  },
  data() {
    return {
      url: 'cobertura',
      ajustes: ['0 %', '10 %', '20 %', '30 %'],
      coberturas: [],
      selected: false,
      errorSelect: false
    };
  },

  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
      this.$validator.reset();
      this.errors.clear();
      this.usedError = '';
      this.selected = false;
      this.errorSelect = false;
    },
    crear() {
      if (!this.selected && this.$validator.validateAll().then(r => r)) {
        this.errorSelect = true;
      } else {
        this.$validator.validateAll().then(r => {
          if (r) {
            this.$emit('crear', this.cobertura);
            this.$validator.reset();
            this.errors.clear();
            this.selected = false;
          }
        });
      }
    },
    cargar() {
      http.load(this.url).then(r => (this.coberturas = r.data.data));
    },

    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid) {
          http
            .update('cobertura', this.cobertura.id, this.cobertura)
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'La cobertura ha sido actualizado con exito'
              );
            })
            .catch(e => console.log(e));
        }
      });
    },
    touchSelect() {
      this.selected = true;
      this.errorSelect = false;
    }
  },
  created() {
    this.cargar();
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
