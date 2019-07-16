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
                <div class="col-md-6">
                  <label>Titulo:</label>
                  <base-input
                    placeholder="Nombre"
                    v-model="notas.nota"
                  >
                  </base-input>
                  <base-input label="Observaciones">
                    <textarea
                      class="form-control"
                      v-model="cliente.observaciones_1"
                    ></textarea>
                  </base-input>
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
import http from './../../../API/http-request.js';
import { EventBus } from './../../../main.js';
import { mixin } from './../../../mixins/mixin.js';

export default {
  props: ['nota', 'modo'],
  mixins: [mixin],
  data() {
    return {
      user_id: '1',
      fecha: new Date(),
      url: 'notas'
    };
  },
  components: {
    SlideYUpTransition,
    Card
  },
  methods: {
    close() {
      EventBus.$emit('resetInput', false);
    },
    crear() {
      this.$emit('crear', this.nota);
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
</style>
