<template>
  <SlideYUpTransition :duration="500">
    <div
      class="modal-backdrop"
      @keydown.esc="close"
      @click="close"
    >
      <div
        @click.stop
        style="width:65%;"
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
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-3">
                    <base-input
                      label="Numero Siniestro"
                      type="text"
                      name="numero_siniestro"
                    ></base-input>
                  </div>
                  <div class="col-md-3">
                    <label>Fecha Denuncia</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        format="d/M/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="siniestro.fecha_denuncia"
                      >
                      </el-date-picker>
                    </base-input>
                  </div>
                  <div class="col-md-3">
                    <label>Fecha Siniestro</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        format="d/M/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="siniestro.fecha_siniestro"
                      >
                      </el-date-picker>
                    </base-input>
                  </div>
                  <div class="col-md-3">
                    <label>Completo</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        format="d/M/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="siniestro.completo"
                      >
                      </el-date-picker>
                    </base-input>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <label>Tipo Reclamo</label>

                    <el-select
                      filterable
                      class="select-primary"
                      name="tipo_reclamo"
                      v-model="siniestro.tipo_reclamo"
                    >
                      <el-option
                        v-for="tipo_reclamo in tipo_reclamos"
                        :key="tipo_reclamo.value"
                        :value="tipo_reclamo.value"
                        :label="tipo_reclamo.label"
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                  </div>
                  <div class="col-md-6">
                    <label>Estado Siniestro</label>
                    <el-select
                      filterable
                      class="select-primary"
                      name="estado_siniestro"
                      v-model="siniestro.estado_siniestro"
                    >
                      <el-option
                        v-for="estado in estados"
                        :key="estado.value"
                        :value="estado.value"
                        :label="estado.label"
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <label>Inspeccion</label>
                        <el-select
                          filterable
                          class="select-primary"
                          name="estado_siniestro"
                          v-model="siniestro.inspeccion"
                        >
                          <el-option
                            v-for="inspeccion in inspecciones"
                            :key="inspeccion.value"
                            :value="inspeccion.value"
                            :label="inspeccion.label"
                            class="select-primary"
                          >
                          </el-option>
                        </el-select>
                      </div>
                      <div class="col-md-6">
                        <label>Orden de Trabajo</label>
                        <el-select
                          filterable
                          class="select-primary"
                          name="estado_siniestro"
                          v-model="siniestro.orden_trabajo"
                        >
                          <el-option
                            v-for="orden_trabajo in orden_trabajos"
                            :key="orden_trabajo.value"
                            :value="orden_trabajo.value"
                            :label="orden_trabajo.label"
                            class="select-primary"
                          >
                          </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-md-6">
                        <label>Cleas | Cia vs. Cia</label>
                        <el-select
                          filterable
                          class="select-primary"
                          name="estado_siniestro"
                          v-model="siniestro.cleas"
                        >
                          <el-option
                            v-for="cleas in cleases"
                            :key="cleas.value"
                            :value="cleas.value"
                            :label="cleas.label"
                            class="select-primary"
                          >
                          </el-option>
                        </el-select>
                      </div>
                      <div class="col-md-6">
                        <label>Taller</label>
                        <el-select
                          filterable
                          class="select-primary"
                          name="taller"
                          v-model="siniestro.taller"
                        >
                          <el-option
                            v-for="taller in talleres"
                            :key="taller.value"
                            :value="taller.value"
                            :label="taller.label"
                            class="select-primary"
                          >
                          </el-option>
                        </el-select>
                      </div>
                    </div>
                    <div class="mt-3">
                      <label>Detalle Siniestro</label>
                      <textarea
                        class="form-control form-control"
                        rows="6"
                        name="detalle_siniestro"
                        v-model="siniestro.detalle_siniestro"
                      ></textarea>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label>Notas</label>
                    <div
                      type="tasks"
                      class="text-left"
                    >
                      <div class="table-full-width table-responsive">
                        <notas></notas>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="modal-pie pull-right mt-3">
              <base-button
                class="btn btn-primary ladda-button"
                type="submit"
              >Crear</base-button>
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
import Notas from './Notas';

export default {
  mixins: [mixin],
  name: 'modal-siniestro',
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    Notas,
    [Option.name]: Option,
    [Select.name]: Select,
    [DatePicker.name]: DatePicker
  },
  data: () => ({
    siniestro: {
      tipo_reclamo: '',
      estado_siniestro: '',
      inspeccion: ''
    },
    fecha_pedido: new Date(),
    tipo_reclamos: [
      {
        value: 'DAÑO A ASEGURADO (Reclamo a Tercero)',
        label: 'DAÑO A ASEGURADO (Reclamo a Tercero)'
      },
      {
        value: 'DAÑO A ASEGURADO (Cleas)',
        label: 'DAÑO A ASEGURADO (Cleas)'
      },
      {
        value: 'DAÑO A ASEGURADO (Cia. vs Cia.)',
        label: 'DAÑO A ASEGURADO (Cia. vs Cia.)'
      },
      {
        value: 'DAÑO PARCIAL (Todo Riesgo)',
        label: 'DAÑO PARCIAL (Todo Riesgo)'
      },
      {
        value: 'SIN RECLAMO (Daño a Tercero)',
        label: 'SIN RECLAMO (Daño a Tercero)'
      }
    ],
    estados: [
      {
        value: 'Abierto',
        label: 'Abierto'
      },
      {
        value: 'Abierto (Reclamo Legal)',
        label: 'Abierto (Reclamo Legal)'
      },
      {
        value: 'Cerrado',
        label: 'Cerrado'
      },
      {
        value: 'Cerrado (Reclamo por cuenta propia)',
        label: 'Cerrado (Reclamo por cuenta propia)'
      }
    ],
    inspecciones: [
      {
        value: 'Pendiente',
        label: 'Pendiente'
      },
      {
        value: 'Inspeccionado',
        label: 'Inspeccionado'
      }
    ],
    orden_trabajos: [
      {
        value: 'Pendiente',
        label: 'Pendiente'
      },
      {
        value: 'Enviada',
        label: 'Enviada'
      }
    ],
    cleases: [
      {
        value: 'Pendiente',
        label: 'Pendiente'
      },
      {
        value: 'A Favor',
        label: 'A Favor'
      },
      {
        value: 'Rechazado',
        label: 'Rechazado'
      }
    ],
    talleres: [
      {
        value: 'Pendiente',
        label: 'Pendiente'
      },
      {
        value: 'En Taller',
        label: 'En Taller'
      },
      {
        value: 'Espera de Repuestos',
        label: 'Espera de Repuestos'
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
.table-responsive {
  padding-bottom: 10px;
  max-height: 200px;
  overflow: hidden;
  overflow-y: scroll;
}
</style>
