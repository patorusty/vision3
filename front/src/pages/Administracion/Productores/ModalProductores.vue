<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @keydown.esc="close"
      @click="close"
    >
      <div
        @click.stop
        class="div-stop"
      >
        <div style="width:50%;">
          <div class="">
            <card>
              <form>
                <div class="d-flex justify-content-between">
                  <!-- ACA VA EL TITULO -->
                  <h4>Organizador</h4>
                  <button
                    class="close"
                    type="button"
                    aria-label="Close"
                    @click="close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <!-- ACA VA EL FORMULARIO -->
                <div class="row">
                  <div class="col-md-6">
                    <label>Nombre</label>
                    <base-input
                      placeholder="Nombre"
                      v-model="productor.nombre"
                      v-validate="modelValidations.nombre"
                      :error="getError('nombre')"
                      name="nombre"
                    >
                    </base-input>
                    <base-input
                      label="Apellido"
                      placeholder="Apellido"
                      v-model="productor.apellido"
                      v-validate="modelValidations.apellido"
                      :error="getError('apellido')"
                      name="apellido"
                    >
                    </base-input>
                    <base-input
                      label="CUIT"
                      placeholder="Cuit"
                      v-model="productor.cuit"
                      v-validate="modelValidations.cuit"
                      :class="{ 'has-danger': cuitUsed }"
                      :error="getErrorCuit('cuit', cuitUsed)"
                      name="cuit"
                      @change="buscarCuit"
                    >
                    </base-input>
                    <base-input
                      label="Matricula"
                      placeholder="Matricula"
                      v-model="productor.matricula"
                      v-validate="modelValidations.matricula"
                      :class="{ 'has-danger': matriculaUsed }"
                      :error="getErrorMatricula('matricula', matriculaUsed)"
                      name="matricula"
                      @change="buscarMatricula"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-6">
                    <base-input
                      label="Email"
                      placeholder="Email"
                      v-model="productor.email"
                      v-validate="modelValidations.email"
                      :error="getError('email')"
                      name="email"
                    >
                    </base-input>
                    <base-input
                      label="Telefono"
                      placeholder="Phone"
                      v-model="productor.telefono_1"
                      v-validate="modelValidations.telefono_1"
                      :error="getError('telefono_1')"
                      name="telefono_1"
                    >
                    </base-input>
                    <base-input
                      label="Celular"
                      placeholder="Phone"
                      v-model="productor.telefono_2"
                      v-validate="modelValidations.telefono_2"
                      :error="getError('telefono_2')"
                      name="telefono_2"
                    >
                    </base-input>
                    <label>Organizador Activo?</label>
                    <base-input>
                      <base-switch
                        v-model="productor.activo"
                        type="primary"
                        on-text="ON"
                        off-text="OFF"
                      ></base-switch>
                    </base-input>
                    &nbsp;
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
  props: ['productor', 'modo'],
  mixins: [mixin],
  data() {
    return {
      cuitUsed: false,
      matriculaUsed: false,
      usedError: '',
      cuits: [],
      matriculas: [],
      url: 'administracion/productores',
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
      this.cuitUsed = false;
      this.matriculaUsed = false;
      this.usedError = '';
      this.$validator.reset();
      this.errors.clear();
      this.$emit('close');
    },
    crear() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed && !this.matriculaUsed) {
          this.$emit('crear', this.productor);
          this.$validator.reset();
          this.errors.clear();
        }
      });
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.cuitUsed && !this.matriculaUsed) {
          http
            .update(this.url, this.productor.id, this.productor)
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'El productor ha sido actualizado con exito'
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
      let query = this.productor.cuit;
      let cuits = [];
      http
        .search('productores/busquedaCuit?q=' + query)
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
      let query = this.productor.matricula;
      let matriculas = [];
      http
        .search('productores/busquedaMatricula?q=' + query)
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
</style>
