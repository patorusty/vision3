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
          <form>
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
            <div class="modal-contenido">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="row">

                      <p class="text-primary">Asegurado: </p>
                      <p class="">Juan Carlos Perez</p>
                    </div>
                    &nbsp;
                    <div class="row">
                      <p class="text-primary">Compañia: Sancor</p>
                      <p class="">Sancor</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <p class="text-primary">Renueva Poliza: </p>
                      <p class="">90909282</p>
                    </div>
                    &nbsp;
                    <div class="row">
                      <p class="text-primary">Productor</p>
                      <p class="">Juan Ignacio Sarno (Cod.1234)</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Select, Option, DatePicker } from 'element-ui';
import { mixin } from '../../../../mixins/mixin.js';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';

export default {
  mixins: [mixin],
  name: 'modal-renovar-automotor',
  components: {
    SlideYUpTransition,
    Card,
    [Option.name]: Option,
    [Select.name]: Select,
    [DatePicker.name]: DatePicker
  },
  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
    }
  }
};
</script>