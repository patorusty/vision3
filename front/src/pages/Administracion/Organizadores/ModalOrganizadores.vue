<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @click="close"
    >
      <div
        class="col-md-6"
        @click.stop
      >
        <card type="secodary">
          <form>
            <div class="modal-titulo d-flex 
            align-item=center ">
              <!-- ACA VA EL TITULO -->
              <h4>Organizador</h4>
              <button
                class="close "
                type="button"
                aria-label="Close"
                @click="close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-contenido">
              <!-- ACA VA EL FORMULARIO -->
              <div class="row">
                <div class="col-md-6">
                  <label
                    for="nombre"
                    class=" control-label"
                  >Nombre</label>
                  <base-input
                    placeholder="Nombre"
                    v-model="organizador.nombre"
                    addon-left-icon="tim-icons icon-single-02"
                    v-validate="modelValidations.nombre"
                    :error="getError('nombre')"
                    name="nombre"
                  >
                  </base-input>
                  <label
                    for="apellido"
                    class="control-label"
                  >Apellido</label>
                  <base-input
                    placeholder="Apellido"
                    v-model="organizador.apellido"
                    addon-left-icon="tim-icons icon-single-02"
                    v-validate="modelValidations.apellido"
                    :error="getError('apellido')"
                    name="apellido"
                  >
                  </base-input>
                  <label
                    for="cuit"
                    class="control-label"
                  >Cuit</label>
                  <base-input
                    placeholder="Cuit"
                    v-model.lazy="organizador.cuit"
                    v-validate="modelValidations.cuit"
                    :class="{ 'has-danger': cuitUsed }"
                    :error="getErrorCuit('cuit', cuitUsed)"
                    name="cuit"
                    @change="buscarCuit"
                  >
                  </base-input>
                  <label
                    for="matricula"
                    class="control-label"
                  >Matricula</label>
                  <base-input
                    placeholder="Matricula"
                    v-model="organizador.matricula"
                    :class="{ 'has-danger': matriculaUsed }"
                    :error="getErrorMatricula('matricula', matriculaUsed)"
                    name="matricula"
                    @change="buscarMatricula"
                  >
                  </base-input>
                </div>
                <div class="col-md-6">
                  <label
                    for="email"
                    class="control-label"
                  >Email</label>
                  <base-input
                    placeholder="Email"
                    v-model="organizador.email"
                    addon-left-icon="tim-icons icon-email-85"
                    v-validate="modelValidations.email"
                    :error="getError('email')"
                    name="email"
                  >
                  </base-input>
                  <label>Telefono</label>
                  <base-input
                    placeholder="Phone"
                    v-model="organizador.telefono_1"
                    addon-left-icon="tim-icons icon-mobile"
                    v-validate="modelValidations.telefono_1"
                    :error="getError('telefono_1')"
                    name="telefono_1"
                  >
                  </base-input>
                  <label>Celular</label>
                  <base-input
                    placeholder="Phone"
                    v-model="organizador.telefono_2"
                    addon-left-icon="tim-icons icon-mobile"
                    v-validate="modelValidations.telefono_2"
                    :error="getError('telefono_2')"
                    name="telefono_2"
                  >
                  </base-input>
                  <label>Organizador Activo?</label>
                  <base-input>
                    <base-switch
                      v-model="organizador.activo"
                      type="primary"
                      on-text="ON"
                      off-text="OFF"
                    ></base-switch>
                  </base-input>
                  &nbsp;
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
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import { BaseSwitch } from 'src/components/index';
import http from '../../../API/http-request.js';
import { EventBus } from '../../../main.js';
import { mixin } from '../../../mixins/mixin.js';

export default {
  props: ['organizador', 'modo'],
  mixins: [mixin],
  data() {
    return {
      cuitUsed: false,
      matriculaUsed: false,
      usedError: '',
      cuits: [],
      matriculas: [],
      url: 'administracion/organizadores',
      modelValidations: {
        nombre: {
          required: true
        },
        apellido: {
          required: true
        },
        cuit: {
          required: true,
          numeric: true,
          max: 11,
          min: 11
        },
        matricula: {
          required: true,
          numeric: true
        },
        email: {
          required: true,
          email: true
        },
        telefono_1: {
          numeric: true
        },
        telefono_2: {
          numeric: true
        }
      }
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch
  },
  methods: {
    close() {
      EventBus.$emit('resetInput', false);
      this.$validator.reset();
      this.errors.clear();
      this.$emit('close');
    },
    crear() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed && !this.matriculaUsed) {
          this.$emit('crear', this.organizador);
          this.$validator.reset();
          this.errors.clear();
        }
      });
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed && !this.matriculaUsed) {
          http
            .update(this.url, this.organizador.id, this.organizador)
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
    getError(fieldName) {
      return this.errors.first(fieldName);
    },
    getErrorCuit(fieldName, cuitUsed) {
      if (!cuitUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este CUIT ya esta en uso';
      }
    },
    getErrorMatricula(fieldName, matriculaUsed) {
      if (!matriculaUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Esta matricula ya esta en uso';
      }
    },
    buscarCuit() {
      let query = this.organizador.cuit;
      let cuits = [];
      http
        .search('organizadores/busquedaCuit?q=' + query)
        .then(r => {
          cuits = r.data.data;
          if (cuits.length > 0) {
            this.cuitUsed = true;
            this.usedError = 'Este CUIT ya esta en uso';
          } else {
            this.cuitUsed = false;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    buscarMatricula() {
      let query = this.organizador.matricula;
      let matriculas = [];
      http
        .search('organizadores/busquedaMatricula?q=' + query)
        .then(r => {
          matriculas = r.data.data;
          if (matriculas.length > 0) {
            this.matriculaUsed = true;
            this.usedError = 'Esta matricula ya esta en uso';
          } else {
            this.matriculaUsed = false;
          }
        })
        .catch(e => {
          console.log(e);
        });
    },
    isTouched() {
      this.touched = true;
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
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-titulo {
  justify-content: space-between;
}
</style>
