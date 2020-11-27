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
                <!-- ACA VA EL TITULO -->
                <div class="d-flex justify-content-between">
                  <h4>Nota</h4>
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
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-9">
                      <label>Titulo:</label>
                      <base-input v-model="notas.titulo">
                      </base-input>
                    </div>
                    <div class="col-md-3">
                      <base-checkbox v-model="notas.hecho"></base-checkbox>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <base-input label="Nota">
                    <textarea
                      v-model="notas.nota"
                      class="form-control"
                    ></textarea>
                  </base-input>
                </div>
                <div class="modal-pie pull-right mt-3">
                  <!-- <base-button
                    v-if="modo == true"
                    class="btn btn-primary ladda-button"
                    type="submit"
                    @click="actualizar"
                  >Guardar</base-button> -->
                  <base-button
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
import http from './../../../API/http-request.js';
import { EventBus } from './../../../main.js';
import { mixin } from './../../../mixins/mixin.js';
import { format } from 'date-fns';

export default {
  props: ['nota', 'modo'],
  mixins: [mixin],
  data() {
    return {
      url: 'notas',
      notas: {
        user_id: 1,
        fecha: format(new Date(), 'DD/MM/YYYY')
      }
    };
  },
  components: {
    SlideYUpTransition,
    Card
  },
  methods: {
    close() {
      EventBus.$emit('resetInput', false);
      this.$emit('close');
    },
    crear() {
      http.create(this.url, this.notas).then(() => {
        this.notifyVue('success', 'Nota Creada');
        EventBus.$emit('cerrarModalNota');
        EventBus.$emit('cargarNotas');
      });
    },
    actualizar() {
      http.update(this.url, this.productor.id, this.productor).then(() => {
        this.close();
        this.$emit('recargar');
        this.notifyVue('success', 'Nota actualizada');
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
.text-right {
  text-align: center !important;
}
</style>
