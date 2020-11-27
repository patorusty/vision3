<template>
  <form>
    <div class="modal-contenido">
      <div class="col-md-12">
        <div class="row ml-1">
          <div class="col-md-6">
            <div class="row pr-3">
              <p class="text-primary">Asegurado:</p>&nbsp;&nbsp;
              <p>{{ poliza.clientes.apellido }}&nbsp;{{ poliza.clientes.nombre }}</p>
            </div>
            <div class="row pr-3">
              <p class="text-primary">Compañia:</p>&nbsp;&nbsp;
              <p>{{ poliza.companias.nombre }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row pr-3">
              <p class="text-primary">Renueva Poliza:</p>&nbsp;&nbsp;
              <p>{{ poliza.numero }}</p>
            </div>
            <div class="row pr-3">
              <p class="text-primary">Productor:</p>&nbsp;&nbsp;
              <p></p>
              <p>{{ poliza.codigo_productor.productores.apellido }}</p>
              <p>{{ poliza.codigo_productor.productores.nombre }}</p>
              <p>- Cod. (</p>
              <p>{{ poliza.codigo_productor.codigo_productor }}</p>
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
              @change="sumarMes"
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
                @change="touchSelect('vigencia_desde')"
              ></el-date-picker>
              <p class="errorSelect" v-show="errorSelect.vigencia_desde">Este campo es obligatorio</p>
            </base-input>
            <label>Hasta:</label>
            <base-input>
              <el-date-picker
                type="date"
                format="dd/MM/yyyy"
                value-format="yyyy-MM-dd"
                v-model="poliza_nueva.vigencia_hasta"
                @change="touchSelect('vigencia_hasta')"
              ></el-date-picker>
              <p class="errorSelect" v-show="errorSelect.vigencia_hasta">Este campo es obligatorio</p>
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
                @change="touchSelect('fecha_solicitud')"
              ></el-date-picker>
            </base-input>
            <label>Emision:</label>
            <base-input class="mb-0">
              <el-date-picker
                v-model="poliza_nueva.fecha_emision"
                type="date"
                format="dd/MM/yyyy"
                value-format="yyyy-MM-dd"
              ></el-date-picker>
            </base-input>
            <label>Recepcion:</label>
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
            <label>Poliza Nro:</label>
            <base-input
              v-model="poliza_nueva.numero"
              class="mb-0"
              type="text"
              :error="getErrorNumero('numero', numeroUsed)"
              :class="{ 'has-danger': numeroUsed }"
              @keyup="buscarNumero"
            ></base-input>
            <label>Envío por Email:</label>
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
                  v-validate="'required'"
                  :error="getError('premio')"
                ></base-input>
              </div>
              <div class="col-md-6">
                <label>Prima:</label>
                <base-input v-model="poliza_nueva.prima" type="text"></base-input>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Comision:</label>
                <base-input
                  v-model="poliza_nueva.comision"
                  type="text"
                  v-validate="'required'"
                  name="comision"
                  :error="getError('comision')"
                ></base-input>
              </div>
              <div class="col-md-6">
                <label>Descuento:</label>
                <base-input v-model="poliza_nueva.descuento" type="text"></base-input>
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
              ></el-option>
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
                  ></el-option>
                </el-select>
              </div>
              <div class="col-md-4 mt-2">
                <label>Cuotas:</label>
                <base-input
                  v-model="poliza.cantidad_cuotas"
                  type="text"
                  v-validate="'required'"
                  name="cantidad_cuotas"
                  :error="getError('cantidad_cuotas')"
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
        <div>
          <div class="pull-right">
            <base-button type="primary" class="right" @click="renovarPoliza">Renovar</base-button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Select, Option, DatePicker } from 'element-ui';
import { mixin } from '../../../../../mixins/mixin.js';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import http from '../../../../../API/http-request.js';
import { EventBus } from '../../../../../main.js';
import { addMonths, startOfHour, setHours } from 'date-fns';
import debounce from '../../../../../debounce.js';

export default {
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
    }
  },
  mixins: [mixin],
  name: 'modal-renovar-automotor',
  components: {
    SlideYUpTransition,
    Card,
    [Option.name]: Option,
    [Select.name]: Select,
    [DatePicker.name]: DatePicker,
    debounce
  },
  data() {
    return {
      poliza_nueva: {
        fecha_solicitud: new Date(),
        vigencia_desde: this.poliza.vigencia_hasta
      },
      riesgo_automotor_nuevo: {
        automotor_tipo: this.riesgo_automotor.automotor_tipo,
        automotor_anio_id: this.riesgo_automotor.automotor_anio_id,
        automotor_marca_id: this.riesgo_automotor.automotor_marca_id,
        automotor_modelo_id: this.riesgo_automotor.automotor_modelo_id,
        automotor_version_id: this.riesgo_automotor.automotor_version_id,
        tipo_patente: this.riesgo_automotor.tipo_patente,
        patente: this.riesgo_automotor.patente,
        nro_motor: this.riesgo_automotor.nro_motor,
        nro_chasis: this.riesgo_automotor.nro_chasis,
        uso: this.riesgo_automotor.uso,
        tipo_carroceria: this.riesgo_automotor.tipo_carroceria,
        combustible: this.riesgo_automotor.combustible,
        okm: this.riesgo_automotor.okm,
        estado_general: this.riesgo_automotor.estado_general,
        color: this.riesgo_automotor.color,
        equipo_rastreo: this.riesgo_automotor.equipo_rastreo,
        gnc: this.riesgo_automotor.gnc,
        gnc_nro_oblea: this.riesgo_automotor.gnc_nro_oblea,
        gnc_vencimiento_oblea: this.riesgo_automotor.gnc_vencimiento_oblea,
        gnc_nro_regulador: this.riesgo_automotor.gnc_nro_regulador,
        gnc_marca_regulador: this.riesgo_automotor.gnc_marca_regulador,
        gnc_nro_cilindro: this.riesgo_automotor.gnc_nro_cilindro,
        gnc_marca_cilindro: this.riesgo_automotor.gnc_marca_cilindro,
        cubiertas_medida: this.riesgo_automotor.cubiertas_medida,
        cubiertas_marca: this.riesgo_automotor.cubiertas_marca,
        accesorio_01: this.accesorio_01,
        valor_accesorio_01: this.riesgo_automotor.valor_accesorio_01,
        accesorio_02: this.accesorio_02,
        valor_accesorio_02: this.riesgo_automotor.valor_accesorio_02,
        acreedor_prendario: this.riesgo_automotor.acreedor_prendario,
        acreedor_rs: this.riesgo_automotor.acreedor_rs,
        acreedor_cuit: this.riesgo_automotor.acreedor_cuit,
        observaciones: this.riesgo_automotor.observaciones,
        cobertura_id: this.riesgo_automotor.cobertura_id,
        franquicia: this.riesgo_automotor.franquicia,
        ajuste: this.riesgo_automotor.ajuste,
        valor_vehiculo: '',
        valor_gnc: this.riesgo_automotor.valor_gnc,
        valor_accesorios: this.riesgo_automotor.valor_accesorios,
        valor_total: this.riesgo_automotor.valor_total,
        vigencia_desde: this.riesgo_automotor.vigencia_desde,
        vigencia_hasta: this.riesgo_automotor.vigencia_hasta
      },
      tipo_vigencias: {},
      forma_pagos: {},
      numeroUsed: false,
      errorSelect: {
        vigencia_desde: false,
        vigencia_hasta: false
      },
      selected: {
        vigencia_desde: false,
        vigencia_hasta: false
      },
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
    },
    getErrorNumero(fieldName, numeroUsed) {
      if (!numeroUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este numero de póliza esta en uso';
      }
    },
    buscarNumero: debounce(function() {
      if (this.poliza_nueva.numero) {
        http
          .search('poliza/busquedaNumero?q=' + this.poliza_nueva.numero)
          .then(r => {
            this.n = r.data.data;
            if (this.n.length > 0) {
              this.numeroUsed = true;
            } else {
              this.numeroUsed = false;
            }
          });
      }
    }, 500),
    touchSelect(val) {
      if (
        !this.poliza_nueva[`${val}`] ||
        this.poliza_nueva[`${val}`] === undefined
      ) {
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
        if (select[1] == false && !this.poliza_nueva[`${select[0]}`]) {
          this.errorSelect[`${select[0]}`] = true;
          valor = false;
        } else {
          this.errorSelect[`${select[0]}`] = false;
          valor = true;
        }
      });
      return valor;
    },
    cargarUltimoNumeroSolicitud() {
      http.load('numerosolicitud').then(response => {
        this.poliza_nueva.numero_solicitud =
          response.data.data[0].numero_solicitud + 1;
      });
    },
    renovarPoliza() {
      this.$validator.validateAll().then(r => {
        if (this.checkSelect() && r && !this.numeroUsedr) {
          EventBus.$emit('renovarP');
          this.notifyVue('success', 'La poliza se ha renovado con exito');
          this.poliza_nueva.cliente_id = this.poliza.cliente_id;
          this.poliza_nueva.tipo_riesgo_id = this.poliza.tipo_riesgo_id;
          this.poliza_nueva.compania_id = this.poliza.compania_id;
          this.poliza_nueva.codigo_productor_id = this.poliza.codigo_productor_id;
          this.poliza_nueva.renueva_numero = this.poliza.numero;
          this.poliza_nueva.tipo_vigencia_id = this.poliza.tipo_vigencia_id;
          this.poliza_nueva.forma_pago_id = this.poliza.forma_pago_id;
          this.poliza_nueva.plan_pago = this.poliza.plan_pago;
          this.poliza_nueva.cantidad_cuotas = this.poliza.cantidad_cuotas;
          this.poliza_nueva.detalle_medio_pago = this.poliza.detalle_medio_pago;
          http.create('polizas', this.poliza_nueva).then(r => {
            this.poliza_renovada = r.data.data;
            this.riesgo_automotor_nuevo.poliza_id = this.poliza_renovada.id;
            http
              .create('/riesgo_automotor', this.riesgo_automotor_nuevo)
              .then(r => {
                this.nuevoRiesgo = r.data.data;
                EventBus.$emit('nuevoRiesgo', this.nuevoRiesgo);
              });
          });
          
        }
      });
    }
  },
  created() {
    this.cargarTipo_Vigencias();
    this.cargarFormaPagos();
    this.sumarMes();
    this.cargarUltimoNumeroSolicitud();
    this.cargarUltimoNumeroSolicitud();
  },
  mounted() {}
};
</script>
<style>
.card-wizard .card-body {
  background-color: transparent;
  margin-top: 0px;
  padding: 0px;
}
.card-wizard {
  margin-bottom: 0px;
}
.card .card-footer {
  padding: 0px;
}
.card-wizard .card-footer {
  background-color: transparent !important;
}
.card-wizard .card-footer .pull-right {
  padding-right: 0px;
}
.card-wizard .card-footer .pull-left {
  padding-left: 0px;
}
</style>
