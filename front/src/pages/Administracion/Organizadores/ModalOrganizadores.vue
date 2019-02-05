<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @click="close">
      <div class="col-md-6" @click.stop>
        <card type="secodary">
          <div class="modal-titulo">
            <!-- ACA VA EL TITULO -->
          </div>
          <div class="modal-contenido">
            <!-- ACA VA EL FORMULARIO -->
          </div>
          <div class="modal-pie pull-right">
            <base-button class="animation-on-hover mr-3" type="primary">Guardar</base-button>
            <base-button
              class="animation-on-hover"
              type="danger"
              @click="close"
              aria-label="Close modal"
            >Cancelar</base-button>
          </div>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>

<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';

export default {
  components: {
    SlideYUpTransition,
    Card,
    BaseButton
  },
  methods: {
    close() {
      this.$emit('close');
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
</style>
