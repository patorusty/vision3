<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
        <div @click.stop style="width:50%;">
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
                      v-model="organizador.nombre"
                      v-validate="modelValidations.nombre"
                      :error="getError('nombre')"
                      name="nombre"
                    >
                    </base-input>
                    <base-input
                      label="Apellido"
                      placeholder="Apellido"
                      v-model="organizador.apellido"
                      v-validate="modelValidations.apellido"
                      :error="getError('apellido')"
                      name="apellido"
                    >
                    </base-input>
                    <base-input
                      label="CUIT"
                      placeholder="CUIT"
                      v-model="organizador.cuit"
                      v-validate="modelValidations.cuit"
                      :class="{ 'has-danger': cuitUsed }"
                      :error="getErrorCuit('cuit', cuitUsed)"
                      name="cuit"
                      @keyup="buscarCuit"
                    >
                    </base-input>
                    <base-input
                      label="Matricula"
                      placeholder="Matricula"
                      v-model="organizador.matricula"
                      v-validate="modelValidations.matricula"
                      :class="{ 'has-danger': matriculaUsed }"
                      :error="getErrorMatricula('matricula', matriculaUsed)"
                      name="matricula"
                      @keyup="buscarMatricula"
                    >
                    </base-input>
                  </div>
                  <div class="col-md-6">
                    <base-input
                      label="Email"
                      placeholder="Email"
                      v-model="organizador.email"
                      v-validate="modelValidations.email"
                      :error="getError('email')"
                      name="email"
                    >
                    </base-input>
                    <base-input
                      label="Telefono"
                      placeholder="Telefono"
                      v-model="organizador.telefono_1"
                      v-validate="modelValidations.telefono_1"
                      :error="getError('telefono_1')"
                      name="telefono_1"
                    >
                    </base-input>
                    <base-input
                      label="Celular"
                      placeholder="Celular"
                      v-model="organizador.telefono_2"
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
import { BaseSwitch } from 'src/components/index';
import http from '../../../API/http-request.js';
import { EventBus } from '../../../main.js';
import { mixin } from '../../../mixins/mixin.js';
import debounce from '../../../debounce.js';

export default {
  props: ['organizador', 'modo'],
  mixins: [mixin],
  data() {
    return {
      cuitUsed: false,
      matriculaUsed: false,
      usedError: '',
      cuit: [],
      matricula: [],
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
      this.$emit('close');
      this.cuitUsed = false;
      this.matriculaUsed = false;
      this.usedError = '';
      this.$validator.reset();
      this.errors.clear();
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
    buscarCuit: debounce(function() {
      if (this.organizador.cuit.length == 11) {
        http
          .search('organizadores/busquedaCuit?q=' + this.organizador.cuit)
          .then(r => {
            this.cuit = r.data.data;
            if (this.cuit.length > 0) {
              this.cuitUsed = true;
              // this.usedError = 'Este CUIT ya esta en uso';
            } else {
              this.cuitUsed = false;
            }
          })
          .catch(e => console.log(e));
      }
    }, 1000),
    buscarMatricula: debounce(function() {
      if (this.organizador.matricula) {
        http
          .search(
            'organizadores/busquedaMatricula?q=' + this.organizador.matricula
          )
          .then(r => {
            this.matricula = r.data.data;
            if (this.matricula.length > 0) {
              this.matriculaUsed = true;
              // this.usedError = 'Esta matricula ya esta en uso';
            } else {
              this.matriculaUsed = false;
            }
          })
          .catch(e => console.log(e));
      }
    }, 1000)
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
</style>
