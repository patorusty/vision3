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
              <h4>Codigo Organizador</h4>
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
                      placeholder="Seleccionar Organizador"
                      v-model="codigo_organizador.organizador_id"
                      v-validate="modelValidations.organizador_id"
                      name="organizador_id"
                      @change="touchSelect"
                    >
                      <el-option
                        v-for="organizador in organizadores"
                        :key="organizador.id"
                        :value="organizador.id"
                        :label="
                          organizador.apellido +
                            ' ' +
                            organizador.nombre +
                            ' (Matricula: ' +
                            organizador.matricula +
                            ')'
                        "
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect"
                    >
                      Debe seleccionar un Organizador
                    </p>
                  </div>
                  <base-input
                    placeholder="Codigo Organizador"
                    v-model="codigo_organizador.codigo_organizador"
                    name="codigo_organizador"
                    v-validate="modelValidations.codigo_organizador"
                    :class="{ 'has-danger': COUsed }"
                    :error="getErrorCO('codigo_organizador', COUsed)"
                    @keyup="buscarCO"
                  ></base-input>
                  <p class="category">Activo?</p>
                  <base-switch
                    v-model="codigo_organizador.activo"
                    type="primary"
                    on-text="ON"
                    off-text="OFF"
                  ></base-switch>
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
import { BaseSwitch } from 'src/components/index';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import debounce from '../../../../debounce.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['codigo_organizador', 'modo'],
  name: 'modal-co',
  mixins: [mixin],
  data() {
    return {
      url: 'administracion/organizadores',
      organizadores: [],
      COUsed: false,
      usedError: '',
      COS: [],
      selected: false,
      errorSelect: false,
      modelValidations: {
        codigo_organizador: {
          required: true
        },
        organizador_id: {
          required: true
        }
      }
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch,
    [Option.name]: Option,
    [Select.name]: Select
  },
  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
      this.$validator.reset();
      this.errors.clear();
      this.COUsed = false;
      this.usedError = '';
      this.selected = false;
      this.errorSelect = false;
    },
    crear() {
      if (!this.selected && this.$validator.validateAll().then(r => r)) {
        this.errorSelect = true;
      } else {
        this.$validator.validateAll().then(r => {
          if (r && !this.COUsed && this.selected && this.COS <= 0) {
            this.$emit('crear', this.codigo_organizador);
            this.$validator.reset();
            this.errors.clear();
            this.selected = false;
          }
        });
      }
    },
    cargar() {
      http.load(this.url).then(r => (this.organizadores = r.data.data));
    },
    getErrorCO(fieldName, COUsed) {
      if (!COUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este codigo organizador ya esta en uso';
      }
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.COUsed) {
          http
            .update(
              'codigoorganizador',
              this.codigo_organizador.id,
              this.codigo_organizador
            )
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'El organizador ha sido actualizado con exito'
              );
            })
            .catch(e => console.log(e));
        }
      });
    },
    touchSelect() {
      this.selected = true;
      this.errorSelect = false;
    },
    buscarCO: debounce(function() {
      if (this.codigo_organizador.codigo_organizador) {
        http
          .search(
            'codigo_organizadores/busquedaCO?q=' +
              this.codigo_organizador.codigo_organizador
          )
          .then(r => {
            this.COS = r.data.data;
            if (this.COS.length > 0) {
              this.COUsed = true;
              this.usedError = 'Este codigo organizador ya esta en uso';
            } else {
              this.COUsed = false;
            }
          });
      }
    }, 500)
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
