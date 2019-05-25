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
              <h4>Endoso</h4>
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
                    <label>Fecha Solicitud</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        format="d/M/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="endoso.fecha_solicitud"
                        @change="touchSelect('fecha_solicitud')"
                        :class="{ errorS: errorSelect.fecha_solicitud }"
                      ></el-date-picker>
                      <p
                        class="errorSelect"
                        v-show="errorSelect.fecha_solicitud"
                      >
                        Este campo es obligatorio
                      </p>
                    </base-input>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label>Tipo Endoso</label>
                    <el-select
                      filterable
                      class="select-primary"
                      name="tipo_endoso_id"
                      v-model="endoso.tipo_endoso_id"
                      :class="{ errorS: errorSelect.tipo_endoso_id }"
                      @change="
                        filtrarModificacionPorTipo(
                          endoso.tipo_endoso_id
                        ),
                        touchSelect('tipo_endoso_id'),
                        reset()
                      "
                    >
                      <el-option
                        v-for="tipo_endoso in tipo_endosos"
                        :key="tipo_endoso.id"
                        :value="tipo_endoso.id"
                        :label="tipo_endoso.nombre"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.tipo_endoso_id"
                    >
                      Este campo es obligatorio
                    </p>
                  </div>
                  <div class="col-md-6">
                    <label>Detalle Endoso</label>
                    <el-select
                      filterable
                      class="select-primary"
                      v-model="endoso.detalle_endoso_id"
                      :class="{ errorS: errorSelect.detalle_endoso_id }"
                      name="detalle_endoso_id"
                      @change="touchSelect('detalle_endoso_id')"
                    >
                      <el-option
                        v-for="detalle in detalles"
                        :key="detalle.id"
                        :value="detalle.id"
                        :label="detalle.nombre"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect.detalle_endoso_id"
                    >
                      Este campo es obligatorio
                    </p>
                  </div>
                </div>
                <label class="mt-3">Detalle</label>
                <base-input>
                  <textarea
                    class="form-control"
                    v-model="endoso.detalle"
                  ></textarea>
                </base-input>
                <div class="row">
                  <div class="col-md-6">
                    <label>Fecha Emision</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        format="d/M/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="endoso.fecha_emision"
                      ></el-date-picker>
                    </base-input>
                  </div>
                  <div class="col-md-6">
                    <base-input
                      label="Numero Endoso"
                      type="text"
                      name="numero_endoso"
                      v-model="endoso.numero_endoso"
                    ></base-input>
                  </div>
                </div>
                <div>
                  <base-checkbox
                    name="completo"
                    v-model="endoso.completo"
                  >Completo</base-checkbox>
                </div>
                <div class="modal-pie pull-right mt-3">
                  <base-button
                    class="btn btn-primary ladda-button"
                    type="submit"
                    @click="actualizar"
                  >Guardar</base-button>
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
import { mixin } from '../../../mixins/mixin.js';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../API/http-request.js';
import { EventBus } from '../../../main.js';
import { BaseCheckbox } from 'src/components/index';

export default {
  props: ['endoso'],
  mixins: [mixin],
  name: 'modal-endosos-editar',
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseCheckbox,
    [Option.name]: Option,
    [Select.name]: Select,
    [DatePicker.name]: DatePicker
  },
  data: () => ({
    url: 'endosos',
    detalles: [],
    tipo_endosos: [],
    errorSelect: {
      fecha_solicitud: false,
      tipo_endoso_id: false,
      detalle_endoso_id: false
    },
    selected: {
      fecha_solicitud: false,
      tipo_endoso_id: false,
      detalle_endoso_id: false
    }
  }),
  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
    },
    actualizar() {
      if (this.checkSelect()) {
        http
          .update('endosos', this.endoso.id, this.endoso)
          .then(() => {
            this.close();
            this.$emit('recargar');
            this.notifyVue('success', 'El endoso ha sido modificado con exito');
          })
          .catch(e => console.log(e));
      }
    },
    cargarTipoEndosos() {
      http.load('tipoendoso').then(r => {
        this.tipo_endosos = r.data.data;
      });
    },
    filtrarModificacionPorTipo(id) {
      http.loadOne('/detallesendosos/filtrar', id).then(r => {
        this.detalles = r.data.data;
      });
    },
    touchSelect(val) {
      if (!this.endoso[`${val}`] || this.endoso[`${val}`] === undefined) {
        this.selected[val] = false;
        this.errorSelect[val] = true;
      } else {
        this.selected[val] = true;
        this.errorSelect[val] = false;
      }
    },
    checkSelect() {
      let valor = true;
      Object.entries(this.selected).forEach(select => {
        if (select[1] == false && !this.endoso[`${select[0]}`]) {
          this.errorSelect[`${select[0]}`] = true;
          valor = false;
        }
      });
      return valor;
    },
    reset() {
      this.endoso.detalle_endoso_id = '';
    }
  },
  created() {
  },
  mounted() {
    EventBus.$on('filtrarTipos', id => {
      this.cargarTipoEndosos();
      console.log(id);
      this.filtrarModificacionPorTipo(id);
    });
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
