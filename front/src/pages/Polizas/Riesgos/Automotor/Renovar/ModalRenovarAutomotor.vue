<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop style="width:60%;">
        <card>
          <div class="d-flex justify-content-between mb-2">
            <h4>Renovacion de Poliza</h4>
            <button class="close" type="button" aria-label="Close" @click="close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <simple-wizard>
            <wizard-tab>
              <poliza :poliza="poliza" :riesgo_automotor="riesgo_automotor"></poliza>
            </wizard-tab>
            <wizard-tab>
              <riesgo
                @close="close"
                :riesgo_automotor="riesgo_automotor"
                :poliza="poliza"
                :coberturas="coberturas"
              ></riesgo>
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
import { EventBus } from '../../../../../main';
// import http from '../../../../../API/http-request.js';
import Poliza from './Poliza';
import Riesgo from './Riesgo';

export default {
  name: 'modal-renovar-automotor',

  props: {
    poliza: {
      type: Object,
      required: true,
      default: null
    },
    riesgo_automotor: {
      type: Object,
      required: true,
      default: null
    },
    coberturas: {
      type: Array
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
      EventBus.$emit('resetInput', false);
      EventBus.$emit('reset');
      this.$emit('close');
    }
  }
};
</script>
