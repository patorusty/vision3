<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @keydown.esc="close"
      @click="close"
    >
      <div
        @click.stop
        style="width:60%;"
      >
        <card>
          <div class="d-flex justify-content-between mb-2">
            <h4>Renovar</h4>
            <button
              class="close"
              type="button"
              aria-label="Close"
              @click="close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <simple-wizard>

            <wizard-tab>
              <poliza :poliza="poliza"></poliza>
            </wizard-tab>

            <wizard-tab>
              <riesgo>hola hola hola</riesgo>
            </wizard-tab>
          </simple-wizard>

        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Card } from 'src/components';
import { SimpleWizard, WizardTab } from 'src/components';
import Poliza from './Poliza';
import Riesgo from './Riesgo';

export default {
  name: 'modal-renovar-automotor',

  props: {
    poliza: {
      type: Object,
      required: true,
      default: null
    }
  },
  components: {
    SlideYUpTransition,
    Card,
    SimpleWizard,
    WizardTab,
    Poliza,
    Riesgo
  },
  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
    }
  }
};
</script>
