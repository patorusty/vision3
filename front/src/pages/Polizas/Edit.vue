<template>
  <div>
    <div class="page-header no-margin-bottom">
      <div class="container-fluid">
        <div class="row">
          <h4 class="text-primary pl-3">POLIZA /</h4>
          <h4 class="">{{ poliza.numero }}</h4>
        </div>
      </div>
    </div>
    <div>
      <div class="block">
        <div class="block-body">
          <div class="row">
            <div class="col-md-12">
              <form @submit.prevent="actualizar">
                <card>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Cliente</label>
                          <el-select
                            filterable
                            name="cliente_id"
                            class="select-primary"
                            value="cliente_id"
                            v-model="poliza.cliente_id"
                          >
                            <el-option
                              v-for="cliente in clientes"
                              class="select-primary"
                              :key="cliente.id"
                              :value="cliente.id"
                              :label="cliente.apellido + ' ' + cliente.nombre + ' | DNI: ' + cliente.nro_dni"
                            ></el-option>
                          </el-select>
                          <label>Tipo Riesgo</label>
                          <el-select
                            filterable
                            name="tipo_riesgo"
                            class="select-primary"
                            value="tipo_riesgo_id"
                            v-model="poliza.tipo_riesgo_id"
                          >
                            <el-option
                              v-for="tipo_riesgo in tipo_riesgos"
                              class="select-primary"
                              :key="tipo_riesgo.id"
                              :value="tipo_riesgo.id"
                              :label="tipo_riesgo.nombre"
                            > {{tipo_riesgo.nombre}}
                            </el-option>
                          </el-select>
                          <label>Compañia</label>
                          <el-select
                            name="compania"
                            class="select-primary"
                            value="compania_id"
                            v-model="poliza.compania_id"
                            @change="
                                cargarCodigos_Productor(poliza.compania_id)
                              "
                          >
                            <el-option
                              class="select-primary"
                              v-for="compania in companias"
                              :key="compania.id"
                              :value="compania.id"
                              :label="compania.nombre"
                            >{{ compania.nombre }}</el-option>
                          </el-select>
                        </div>
                        <div class="col-md-6">
                          <label>Codigo Productor</label>
                          <el-select
                            name="codigo_productor"
                            class="select-primary"
                            value="codigo_productor_id"
                            v-model="poliza.codigo_productor_id"
                          >
                            <el-option
                              class="select-primary"
                              v-for="codigo_productor in codigo_productores"
                              :key="codigo_productor.id"
                              :value="codigo_productor.id"
                              :label="codigo_productor.productores.apellido + ' ' + codigo_productor.productores.nombre + ' | Cod. (' + codigo_productor.codigo_productor + ')'"
                            ></el-option>
                          </el-select>
                          <label>Poliza N:</label>
                          <base-input
                            type="text"
                            name="numero"
                            v-model="poliza.numero"
                            placeholder=""
                          ></base-input>
                          <label for="numero_solicitud">Nro de Solicitud:</label>
                          <p class="text-primary">{{ poliza.numero_solicitud }}</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Vigencia</label>
                          <el-select
                            name="tipo_vigencia"
                            class="select-primary"
                            value="tipo_vigencia_id"
                            v-model="poliza.tipo_vigencia_id"
                          >
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
                              v-model="poliza.vigencia_desde"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Hasta:</label>
                          <base-input>
                            <el-date-picker
                              v-model="poliza.vigencia_hasta"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>

                        </div>

                        <div class="col-md-4">
                          <label>Solicitud:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_solicitud"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Emision:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_emision"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Recepcion:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_recepcion"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>

                        </div>

                        <div class="col-md-4">
                          <label>Entrega Original:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.entrega_original"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Enviado x Email:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.entrega_email"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Entrega Correo:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_entrega_correo"
                              type="date"
                              format="d/M/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-3">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Premio:</label>
                          <base-input
                            type="text"
                            name="numero"
                            v-model="poliza.premio"
                            placeholder=""
                          ></base-input>
                        </div>
                        <div class="col-md-6">
                          <label>Prima:</label>
                          <base-input
                            type="text"
                            name="numero"
                            v-model="poliza.prima"
                            placeholder=""
                          ></base-input>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label>Comision:</label>
                          <base-input
                            type="text"
                            name="numero"
                            v-model="poliza.comision"
                            placeholder=""
                          ></base-input>
                        </div>
                        <div class="col-md-6">
                          <label>Descuento:</label>
                          <base-input
                            type="text"
                            name="numero"
                            v-model="poliza.descuento"
                            placeholder=""
                          ></base-input>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>Medio de Pago:</label>
                      <el-select
                        filterable
                        name="medio_pago"
                        class="select-primary"
                        v-model="poliza.medio_pago"
                      >
                        <el-option
                          v-for="medio_pago in medio_pagos"
                          :key="medio_pago.value"
                          :label="medio_pago.label"
                          :value="medio_pago.value"
                          class="select-primary"
                        >
                        </el-option>
                      </el-select>
                      <div class="row">
                        <div class="col-md-8 mt-2">
                          <label>Plan de Pago:</label>
                          <el-select
                            filterable
                            name="medio_pago"
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
                            type="text"
                            name="numero"
                            v-model="poliza.cantidad_cuotas"
                            placeholder=""
                          ></base-input>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <label>Detalle:</label>
                      <textarea
                        class="form-control form-control"
                        rows="6"
                        id="detalle_medio_pago"
                        name="detalle_medio_pago"
                        v-model="poliza.detalle_medio_pago"
                      ></textarea>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end align-items-end">
                      <button
                        type="submit"
                        class="btn btn-primary"
                      >Guardar</button>
                    </div>
                  </div>
                </card>
              </form>
            </div>
            <!-- aca deberia mostrar la tabla segun el tipo de riesgo -->
            <!-- aca meter la tabla -->
            <tabla-riesgo-automotor
              v-if="(poliza.tipo_riesgo_id == '1' && dataLoaded)"
              :poliza="poliza"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option, DatePicker } from 'element-ui';
import { mixin } from './../../mixins/mixin.js';
import { EventBus } from './../../../src/main.js';
import http from '../../../../front/src/API/http-request.js';
import TablaRiesgoAutomotor from './Riesgos/Automotor/TablaAutomotor';
import { BaseSwitch, ImageUpload } from 'src/components/index';

export default {
  mixins: [mixin],
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    ImageUpload,
    BaseSwitch,
    TablaRiesgoAutomotor,
    [Select.name]: Select,
    [Option.name]: Option,
    [DatePicker.name]: DatePicker
  },
  data() {
    return {
      poliza: {},
      clientes: {},
      companias: {},
      tipo_riesgos: {},
      codigo_productores: {},
      tipo_vigencias: {},
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
      ],
      medio_pagos: [
        {
          value: 'TARJETA DE CREDITO',
          label: 'TARJETA DE CREDITO'
        },
        {
          value: 'DEBITO EN CUENTA',
          label: 'DEBITO EN CUENTA'
        },
        {
          value: 'RAPIPAGO / PAGOFACIL',
          label: 'RAPIPAGO / PAGOFACIL'
        }
      ],
      numeroSolicitud: this.$route.params.numero_solicitud,
      dataLoaded: false
    };
  },
  methods: {
    // sumarMes(mes) {
    //   var mes;

    //   switch (this.poliza.tipo_vigencia_id) {
    //     case 6:
    //       var mes = 12;
    //       break;
    //     case 5:
    //       var mes = 6;
    //       break;
    //     case 4:
    //       var mes = 4;
    //       break;
    //     case 3:
    //       var mes = 3;
    //       break;
    //     case 2:
    //       var mes = 2;
    //       break;
    //     case 1:
    //       var mes = 1;
    //       break;
    //   }
    //   this.poliza.vigencia_hasta = addMonths(this.poliza.vigencia_desde, mes)
    //     .toISOString()
    //     .slice(0, 10);
    // },

    //     sumarSoloMes(mes){
    //        this.poliza.vigencia_hasta = addMonths(this.poliza.vigencia_desde, mes)
    //         .toISOString()
    //         .slice(0, 10);
    //     },

    cargarPoliza() {
      http.loadOne('polizas', this.numeroSolicitud).then(response => {
        this.poliza = response.data.data[0];
        this.dataLoaded = true;
        EventBus.$emit('poliza_id', this.poliza.id);
        http
          .loadOne('codigoproductor/compania', this.poliza.compania_id)
          .then(response => {
            this.codigo_productores = response.data.data;
          })
          .catch(err => {
            console.log(err);
          });
      });
    },
    actualizar() {
      http.update('polizas', this.poliza.id, this.poliza).then(() => {
        EventBus.$emit('resetInput', false);
        this.notifyVue('success', 'La poliza ha sido actualizado con exito');
      });
    },
    cargarClientes() {
      http.load('clientes').then(response => {
        this.clientes = response.data.data;
      });
    },
    cargarTipo_Riesgos() {
      http.load('tiporiesgo').then(response => {
        this.tipo_riesgos = response.data.data;
      });
    },
    cargarTipo_Vigencias() {
      http.load('tipovigencia').then(response => {
        this.tipo_vigencias = response.data.data;
      });
    },
    cargarCompanias() {
      http.load('administracion/companias').then(response => {
        this.companias = response.data.data;
      });
    },
    cargarCodigos_ProductorOnChange(id) {
      http
        .loadOne('compania', id)
        .then(response => {
          this.codigo_productores = response.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },

  created() {
    this.cargarPoliza();
    this.cargarClientes();
    this.cargarTipo_Riesgos();
    this.cargarCompanias();
    this.cargarTipo_Vigencias();
    //     this.cargarCodigos_Productor();
  },
  mounted() {}
};
</script>
