<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop">
      <div
        @click.stop
        style="width:40%;"
      >
        <card>
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Renovar</h4>
              <button
                class="close"
                type="button"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-contenido">

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
  }
};
</script>