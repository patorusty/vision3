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
                <div class="row ml-1">
                  <div class="col-md-6">
                    <div class="row ">
                      <p class="text-primary">Asegurado: </p> &nbsp;

                      <p class="">{{poliza.clientes.apellido}}</p>&nbsp;
                      <p class="">{{poliza.clientes.nombre}}</p>
                    </div>
                    &nbsp;
                    <div class="row">
                      <p class="text-primary">Compañia: </p> &nbsp;

                      <p class="">{{poliza.companias.nombre}}</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <p class="text-primary">Renueva Poliza: </p> &nbsp;

                      <p class="">{{poliza.numero}}</p>
                    </div>
                    &nbsp;
                    <div class="row">
                      <p class="text-primary">Productor:</p> &nbsp;

                      <p class=""></p>
                      <p class="">{{poliza.codigo_productor.productores.apellido}}</p>&nbsp;
                      <p class="">{{poliza.codigo_productor.productores.nombre}}</p>&nbsp;
                      <p> - Cod. &nbsp;(</p>
                      <p class="">{{poliza.codigo_productor.codigo_productor}}</p>
                      <p>)</p>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-4">
                    <label>Vigencia</label>
                    <el-select
                      name="tipo_vigencia"
                      class="select-primary"
                      value="tipo_vigencia_id"
                      v-model="poliza.tipo_vigencia_id"
                    >
                      <el-option
                        class="select-primary"
                        v-for="tipo_vigencia in tipo_vigencias"
                        :key="tipo_vigencia.id"
                        :value="tipo_vigencia.id"
                        :label="tipo_vigencia.vigencia"
                      ></el-option>
                    </el-select>
                    <label>Desde</label>
                    <base-input class="mb-0">
                      <el-date-picker
                        type="date"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="poliza_nueva.vigencia_desde"
                      ></el-date-picker>
                    </base-input>
                    <label>Hasta:</label>
                    <base-input>
                      <el-date-picker
                        type="date"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                        v-model="poliza_nueva.vigencia_hasta"
                      ></el-date-picker>
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <label>Solicitud:</label>
                    <base-input class="mb-0">
                      <el-date-picker
                        v-model="poliza_nueva.fecha_solicitud"
                        type="date"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                      ></el-date-picker>
                    </base-input><label>Emision:</label>
                    <base-input class="mb-0">
                      <el-date-picker
                        v-model="poliza_nueva.fecha_emision"
                        type="date"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                      ></el-date-picker>
                    </base-input><label>Recepcion:</label>
                    <base-input class="mb-0">
                      <el-date-picker
                        v-model="poliza_nueva.fecha_recepcion"
                        type="date"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                      ></el-date-picker>
                    </base-input>
                  </div>
                  <div class="col-md-4">
                    <label>Numero Poliza:</label>
                    <base-input
                      v-model="poliza_nueva.numero"
                      class="mb-0"
                    >
                    </base-input><label>Email:</label>
                    <base-input class="mb-0">
                      <el-date-picker
                        v-model="poliza_nueva.entrega_email"
                        type="date"
                        format="dd/MM/yyyy"
                        value-format="yyyy-MM-dd"
                      ></el-date-picker>
                    </base-input>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Premio:</label>
                        <base-input
                          v-model="poliza_nueva.premio"
                          type="text"
                          name="premio"
                        ></base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Prima:</label>
                        <base-input
                          v-model="poliza_nueva.prima"
                          type="text"
                        ></base-input>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Comision:</label>
                        <base-input
                          v-model="poliza_nueva.comision"
                          type="text"
                          name="comision"
                        ></base-input>
                      </div>
                      <div class="col-md-6">
                        <label>Descuento:</label>
                        <base-input
                          v-model="poliza_nueva.descuento"
                          type="text"
                        ></base-input>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label>Medio de Pago:</label>
                    <el-select
                      filterable
                      name="forma_pago"
                      class="select-primary"
                      value="forma_pago_id"
                      v-model="poliza.forma_pago_id"
                    >
                      <el-option
                        v-for="forma_pago in forma_pagos"
                        :key="forma_pago.id"
                        :value="forma_pago.id"
                        :label="forma_pago.nombre"
                        class="select-primary"
                      >
                      </el-option>
                    </el-select>
                    <div class="row">
                      <div class="col-md-8 mt-2">
                        <label>Plan de Pago:</label>
                        <el-select
                          filterable
                          name="plan_pago"
                          class="select-primary"
                          v-model="poliza.plan_pago"
                        >
                          <el-option
                            v-for="plan_pago in plan_pagos"
                            :key="plan_pago.value"
                            :label="plan_pago.label"
                            :value="plan_pago.value"
                            class="select-primary"
                          >
                          </el-option>
                        </el-select>
                      </div>
                      <div class="col-md-4 mt-2">
                        <label>Cuotas:</label>
                        <base-input
                          v-model="poliza.cantidad_cuotas"
                          type="text"
                          placeholder=""
                          name="cantidad_cuotas"
                        ></base-input>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 d-flex flex-column justify-content-between">
                    <label>Detalle:</label>
                    <textarea
                      class="form-control form-control"
                      rows="6"
                      name="detalle_medio_pago"
                      v-model="poliza.detalle_medio_pago"
                    ></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-pie pull-right mt-3">
                <button
                  @click="cargarPoliza"
                  type="submit"
                  class="btn btn-primary"
                >
                  Siguiente
                </button>
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
import { addMonths, startOfHour, setHours } from 'date-fns';

export default {
  props: {
    poliza: {
      type: Object,
      required: true,
      default: null
    }
  },
  mixins: [mixin],
  name: 'modal-renovar-automotor',
  components: {
    SlideYUpTransition,
    Card,
    [Option.name]: Option,
    [Select.name]: Select,
    [DatePicker.name]: DatePicker
  },
  data() {
    return {
      poliza_nueva: {
        vigencia_desde: this.poliza.vigencia_hasta,
        vigencia_hasta: '',
        fecha_solicitud: new Date()
      },
      tipo_vigencias: {},
      forma_pagos: {},
      plan_pagos: [
        {
          value: 'MENSUAL',
          label: 'MENSUAL'
        },
        {
          value: 'TRIMESTRAL',
          label: 'TRIMESTRAL'
        },
        {
          value: 'SEMESTRAL',
          label: 'SEMESTRAL'
        },
        {
          value: 'ANUAL',
          label: 'ANUAL'
        },
        {
          value: 'TOTAL',
          label: 'TOTAL'
        }
      ]
    };
  },
  methods: {
    sumarMes(mes) {
      switch (this.poliza.tipo_vigencia_id) {
        case 6:
          mes = 12;
          break;
        case 5:
          mes = 6;
          break;
        case 4:
          mes = 4;
          break;
        case 3:
          mes = 3;
          break;
        case 2:
          mes = 2;
          break;
        case 1:
          mes = 1;
          break;
      }
      this.poliza_nueva.vigencia_hasta = addMonths(
        this.poliza_nueva.vigencia_desde,
        mes
      );
    },
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
    },
    cargarTipo_Vigencias() {
      http.load('tipovigencia').then(response => {
        this.tipo_vigencias = response.data.data;
      });
    },
    cargarFormaPagos() {
      http.load('formapagos').then(response => {
        this.forma_pagos = response.data.data;
      });
    },
    cargarPoliza() {
      this.$emit('envioPoliza', this.poliza);
    }
  },
  created() {
    this.cargarTipo_Vigencias();
    this.cargarFormaPagos();
    this.sumarMes();
  }
};
</script>