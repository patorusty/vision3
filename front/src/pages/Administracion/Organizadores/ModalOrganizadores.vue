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
          <form @submit.prevent="crearOrganizador()">
            <div class="modal-titulo d-flex 
            align-item=center ">
              <!-- ACA VA EL TITULO -->
              <h4>Organizador</h4>
              <button
                class="
            close "
                type="
            button"
                data-dismiss="modal"
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
                    required
                    placeholder="Nombre"
                    v-model="organizador.nombre"
                    addon-left-icon="tim-icons icon-single-02"
                  >
                  </base-input>
                  <label
                    for="apellido"
                    class="control-label"
                  >Apellido</label>
                  <base-input
                    required
                    placeholder="Apellido"
                    v-model="organizador.apellido"
                    addon-left-icon="tim-icons icon-single-02"
                  >
                  </base-input>
                  <label
                    for="cuit"
                    class="control-label"
                  >Cuit</label>
                  <base-input
                    required
                    placeholder="Cuit"
                    v-model="organizador.cuit"
                  >
                  </base-input>
                  <label
                    for="matricula"
                    class="control-label"
                  >Matricula</label>
                  <base-input
                    required
                    placeholder="Matricula"
                    v-model="organizador.matricula"
                  >
                  </base-input>

                </div>
                <div class="col-md-6">
                  <label
                    for="email"
                    class="control-label"
                  >Email</label>
                  <base-input
                    required
                    placeholder="Email"
                    v-model="organizador.email"
                    addon-left-icon="tim-icons icon-email-85"
                  >
                  </base-input>

                  <label>Telefono</label>
                  <base-input
                    required
                    placeholder="Phone"
                    v-model="organizador.telefono_01"
                    addon-left-icon="tim-icons icon-mobile"
                  >
                  </base-input>
                  <label>Celular</label>
                  <base-input
                    required
                    placeholder="Phone"
                    v-model="organizador.telefono_2"
                    addon-left-icon="tim-icons icon-mobile"
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
                class="btn btn-primary ladda-button"
                type="submit"
              >Guardar</base-button>
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
import axios from 'axios';
import { BaseProgress, BaseSwitch, TagsInput } from 'src/components/index';
export default {
  data() {
    return {
      organizadores: {},
      organizador: {
        nombre: '',
        apellido: '',
        cuit: '',
        matricula: '',
        email: '',
        telefono_1: '',
        telefono_2: '',
        activo: ''
      },
      modoEditar: false
    };
  },

  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch
  },

  methods: {
    crearOrganizador() {
      axios
        .post(
          'http://127.0.0.1:8000/api/administracion/organizadores',
          this.organizador
        )
        .then(() => {
          this.organizador = {};
          this.organizador.activo = true;
        })
        .catch(e => console.log(e));
    },
    cargarOrganizadores() {
      axios
        .get('http://127.0.0.1:8000/api/administracion/organizadores')
        .then(response => {
          this.dataLoaded = true;

          this.organizadores = response.data.data;
        });
    },
    close() {
      this.$emit('close');
    }
  },
  created() {
    this.cargarOrganizadores();
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
