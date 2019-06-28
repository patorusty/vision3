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
              <form @submit.prevent="crearPoliza">
                <card>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Asegurado</label>
                          <el-select
                            filterable
                            name="cliente_id"
                            class="select-primary"
                            value="cliente_id"
                            v-model="poliza.cliente_id"
                            :class="{ errorS: errorSelect.cliente_id }"
                            @change="touchSelect('cliente_id')"
                          >
                            <el-option
                              v-for="cliente in clientes"
                              class="select-primary"
                              :key="cliente.id"
                              :value="cliente.id"
                              :label="
                                cliente.apellido +
                                  ' ' +
                                  cliente.nombre +
                                  ' | DNI: ' +
                                  cliente.nro_dni
                              "
                            ></el-option>
                          </el-select>
                          <p
                            class="errorSelect"
                            v-show="errorSelect.cliente_id"
                          >
                            Este campo es obligatorio
                          </p>
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
                            >
                              {{ tipo_riesgo.nombre }}
                            </el-option>
                          </el-select>
                          <label>Compañia</label>
                          <el-select
                            name="compania"
                            class="select-primary"
                            value="compania_id"
                            v-model="poliza.compania_id"
                            :class="{ errorS: errorSelect.compania_id }"
                            @change="
                              cargarCodigos_Productor(poliza.compania_id);
                              touchSelect('compania_id');
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
                          <p
                            class="errorSelect"
                            v-show="errorSelect.compania_id"
                          >
                            Este campo es obligatorio
                          </p>
                        </div>
                        <div class="col-md-6">
                          <label>Codigo Productor</label>
                          <el-select
                            name="codigo_productor"
                            class="select-primary"
                            value="codigo_productor_id"
                            v-model="poliza.codigo_productor_id"
                            :class="{ errorS: errorSelect.codigo_productor_id }"
                            @change="touchSelect('codigo_productor_id')"
                          >
                            <el-option
                              class="select-primary"
                              v-for="codigo_productor in codigo_productores"
                              :key="codigo_productor.id"
                              :value="codigo_productor.id"
                              :label="
                                codigo_productor.productores.apellido +
                                  ' ' +
                                  codigo_productor.productores.nombre +
                                  ' | Cod. (' +
                                  codigo_productor.codigo_productor +
                                  ')'
                              "
                            ></el-option>
                          </el-select>
                          <p
                            class="errorSelect"
                            v-show="errorSelect.codigo_productor_id"
                          >
                            Este campo es obligatorio
                          </p>
                          <label>Poliza Nro:</label>
                          <base-input
                            type="text"
                            name="numero"
                            v-model="poliza.numero"
                            placeholder=""
                            :error="getErrorNumero('numero', numeroUsed)"
                            :class="{ 'has-danger': numeroUsed }"
                            @keyup="buscarNumero"
                          ></base-input>
                          <div class="row">
                            <div class="col-md-6">
                              <label for="numero_solicitud">Renueva Poliza Nro:</label>
                              <p class="text-primary">
                                {{ poliza.renueva_numero }}
                              </p>
                            </div>
                            <div class="col-md-6">
                              <label for="numero_solicitud">Nro de Solicitud:</label>
                              <p class="text-primary">
                                {{ poliza.numero_solicitud }}
                              </p>
                            </div>
                          </div>
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
                              v-model="poliza.vigencia_desde"
                              type="date"
                              format="dd/MM/yyyy"
                              value-format="yyyy-MM-dd"
                              @change="touchSelect('vigencia_desde')"
                            ></el-date-picker>
                            <p
                              class="errorSelect"
                              v-show="errorSelect.vigencia_desde"
                            >
                              Este campo es obligatorio
                            </p>
                          </base-input>
                          <label>Hasta:</label>
                          <base-input>
                            <el-date-picker
                              v-model="poliza.vigencia_hasta"
                              type="date"
                              format="dd/MM/yyyy"
                              value-format="yyyy-MM-dd"
                              @change="touchSelect('vigencia_hasta')"
                            ></el-date-picker>
                            <p
                              class="errorSelect"
                              v-show="errorSelect.vigencia_hasta"
                            >
                              Este campo es obligatorio
                            </p>
                          </base-input>
                        </div>
                        <div class="col-md-4">
                          <label>Solicitud:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_solicitud"
                              type="date"
                              format="dd/MM/yyyy"
                              value-format="yyyy-MM-dd"
                              @change="touchSelect('fecha_solicitud')"
                            ></el-date-picker>
                          </base-input>
                          <label>Emision:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_emision"
                              type="date"
                              format="dd/MM/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Recepcion:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_recepcion"
                              type="date"
                              format="dd/MM/yyyy"
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
                              format="dd/MM/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Enviado x Email:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.entrega_email"
                              type="date"
                              format="dd/MM/yyyy"
                              value-format="yyyy-MM-dd"
                            ></el-date-picker>
                          </base-input>
                          <label>Entrega Correo:</label>
                          <base-input class="mb-0">
                            <el-date-picker
                              v-model="poliza.fecha_entrega_correo"
                              type="date"
                              format="dd/MM/yyyy"
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
                            v-model="poliza.premio"
                            placeholder=""
                            v-validate="'required'"
                            name="premio"
                            :error="getError('premio')"
                          ></base-input>
                        </div>
                        <div class="col-md-6">
                          <label>Prima:</label>
                          <base-input
                            type="text"
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
                            v-model="poliza.comision"
                            placeholder=""
                            v-validate="'required'"
                            name="comision"
                            :error="getError('comision')"
                          ></base-input>
                        </div>
                        <div class="col-md-6">
                          <label>Descuento:</label>
                          <base-input
                            type="text"
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
                            v-model="poliza.cantidad_cuotas"
                            placeholder=""
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
                        id="detalle_medio_pago"
                        name="detalle_medio_pago"
                        v-model="poliza.detalle_medio_pago"
                      ></textarea>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end align-items-end">
                      <button
                        type="submit"
                        class="btn btn-primary"
                      >
                        Crear
                      </button>
                    </div>
                  </div>
                </card>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Select, Option, DatePicker } from 'element-ui';
import { mixin } from './../../mixins/mixin.js';
import http from '../../../../front/src/API/http-request.js';
import TablaRiesgoAutomotor from './Riesgos/Automotor/TablaAutomotor';
import { addMonths, startOfHour, setHours } from 'date-fns';
import debounce from '../../debounce.js';

export default {
  mixins: [mixin],
  components: {
    TablaRiesgoAutomotor,
    [Select.name]: Select,
    [Option.name]: Option,
    [DatePicker.name]: DatePicker
  },
  data() {
    return {
      poliza: {
        tipo_vigencia_id: 6,
        medio_pago: 'TARJETA DE CREDITO',
        tipo_riesgo_id: 1,
        plan_pago: 'MENSUAL',
        vigencia_desde: setHours(startOfHour(new Date()), 12),
        vigencia_hasta: '',
        fecha_solicitud: new Date(),
        premio: '',
        prima: '',
        comision: '',
        descuento: 0,
        cantidad_cuotas: 12
      },
      clientes: {},
      companias: {},
      tipo_riesgos: {},
      codigo_productores: {},
      tipo_vigencias: {},
      numeroUsed: false,
      errorSelect: {
        cliente_id: false,
        compania_id: false,
        codigo_productor_id: false,
        vigencia_desde: false,
        vigencia_hasta: false
      },
      selected: {
        cliente_id: false,
        compania_id: false,
        codigo_productor_id: false,
        vigencia_desde: true,
        vigencia_hasta: true
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
      ],
      medio_pagos: [
        {
          value: 'TARJETA DE CREDITO',
          label: 'TC'
        },
        {
          value: 'DEBITO EN CUENTA',
          label: 'DC'
        },
        {
          value: 'RAPIPAGO / PAGOFACIL',
          label: 'RP / PF'
        }
      ],
      dataLoaded: false
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
      this.poliza.vigencia_hasta = addMonths(this.poliza.vigencia_desde, mes);
    },

    cargarUltimoNumeroSolicitud() {
      http.load('numerosolicitud').then(response => {
        this.poliza.numero_solicitud =
          response.data.data[0].numero_solicitud + 1;
      });
    },
    crearPoliza() {
      if (
        this.$validator.validateAll().then(r => r) &&
        this.checkSelect() &&
        !this.numeroUsed
      ) {
        var param = this.poliza.numero_solicitud;
        http.create('polizas', this.poliza).then(() => {
          this.poliza = {};
          this.$router.push({
            name: 'Editar Poliza',
            params: { numero_solicitud: param }
          });
        });
      }
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
    cargarCodigos_Productor(id) {
      http
        .loadOne('codigoproductor/compania', id)
        .then(response => {
          this.codigo_productores = response.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    getErrorNumero(fieldName, numeroUsed) {
      if (!numeroUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este numero de póliza esta en uso';
      }
    },
    buscarNumero: debounce(function() {
      if (this.poliza.numero) {
        http.search('poliza/busquedaNumero?q=' + this.poliza.numero).then(r => {
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
      if (!this.poliza[`${val}`] || this.poliza[`${val}`] === undefined) {
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
        if (select[1] == false) {
          this.errorSelect[`${select[0]}`] = true;
          valor = false;
        }
      });
      return valor;
    }
  },

  created() {
    this.cargarUltimoNumeroSolicitud();
    this.cargarClientes();
    this.cargarTipo_Riesgos();
    this.cargarCompanias();
    this.cargarTipo_Vigencias();
    this.sumarMes();
  }
};
</script>
