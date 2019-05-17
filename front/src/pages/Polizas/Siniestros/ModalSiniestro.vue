<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @keydown.esc="close"
      @click="close"
    >
      <div
        @click.stop
        style="width:35%;"
      >
        <card>
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Siniestro</h4>
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
import { mixin } from '../../../mixins/mixin.js';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../API/http-request.js';
import { EventBus } from '../../../main.js';

export default {
  mixins: [mixin],
  name: 'modal-siniestro',
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    [Option.name]: Option,
    [Select.name]: Select,
    [DatePicker.name]: DatePicker
  },
  data: () => ({
    fecha_pedido: new Date(),
    condiciones: [
      {
        value: 'Consumidor Final',
        label: 'Consumidor Final'
      },
      {
        value: 'Monotributo',
        label: 'Monotributo'
      },
      {
        value: 'Resp. Inscripto',
        label: 'Resp. Inscripto'
      }
    ]
  }),
  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
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
.el-select {
  display: block;
}
.errorSelect {
  color: #ec250d !important;
  font-size: 0.75rem;
  margin-bottom: 5px;
  margin-top: 5px;
}
</style>
