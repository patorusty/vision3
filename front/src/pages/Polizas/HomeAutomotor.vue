<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <div class="row">
            <div class="col-md-10">

              <div class="botoncrear col-md-2">
                <router-link to="/polizas/create">
                  <base-button
                    class="right"
                    type="primary"
                  >Crear</base-button>
                </router-link>
              </div>
            </div>
          </div>
        </card>
        <!-- ACA EMPIEZA LA TABLA -->
        <card card-body-classes="table-full-width">
          <div>

            <el-table :data="queriedData">
              <el-table-column
                label="Poliza N°"
                prop="numero"
                :min-width="127"
              ></el-table-column>
              <el-table-column
                label="Compania"
                :min-width="113"
              >
                <div slot-scope="{ row }">{{row.companias.nombre}} <br>
                  Cod.({{row.codigo_productor.codigo_productor}})</div>
              </el-table-column>
              <el-table-column
                label="Asegurado"
                :min-width="128"
              >
                <div slot-scope="{ row }">
                  <router-link
                    v-if="row.clientes.razon_social === null"
                    to="#"
                  >{{ row.clientes.apellido }} <br> {{ row.clientes.nombre }}</router-link>
                  <router-link
                    v-else
                    to="#"
                  >{{ row.clientes.razon_social }}</router-link>
                </div>
              </el-table-column>
              <el-table-column
                label="Patente"
                :min-width="100"
              >
                <div slot-scope="{ row }">{{row.vigencia_desde}}</div>
              </el-table-column>
              <el-table-column
                label="Vigencia"
                :min-width="100"
                prop="tipo_vigencias.vigencia"
              ></el-table-column>
              <el-table-column
                label="Desde/Hasta"
                :min-width="141"
                sortable
              >
                <div slot-scope="{ row }">{{row.vigencia_desde}} <br> {{row.vigencia_hasta}}</div>
              </el-table-column>
              <el-table-column
                label="Estado"
                prop="estado_polizas.nombre"
                :min-width="109"
              ></el-table-column>
              <el-table-column
                :min-width="117"
                label="Envio"
              >
                <div slot-scope="{ row }">
                  <div v-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo === null && row.fecha_entrega_email === null">Recibida</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo === null && row.fecha_entrega_email === null">
                    <el-tooltip
                      content="Entregada"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-check-2"></i>
                    </el-tooltip>

                  </div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo !== null && row.fecha_entrega_email === null">
                    <el-tooltip
                      content="Enviada por Correo"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-send"></i>
                    </el-tooltip>
                  </div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo === null && row.fecha_entrega_email !== null">

                    <el-tooltip
                      content="Email"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-email-85"></i>
                    </el-tooltip>

                  </div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo !== null && row.fecha_entrega_email === null">
                    <el-tooltip
                      content="Entregada"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-check-2"></i>
                    </el-tooltip>
                    / <el-tooltip
                      content="Enviada por Correo"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-send"></i>
                    </el-tooltip>
                  </div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo === null && row.fecha_entrega_email !== null">
                    <el-tooltip
                      content="Entregada"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-check-2"></i>
                    </el-tooltip>
                    / <el-tooltip
                      content="Email"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-email-85"></i>
                    </el-tooltip>
                  </div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo !== null && row.fecha_entrega_email !== null">
                    <el-tooltip
                      content="Enviada por Correo"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-send"></i>
                    </el-tooltip>
                    / <el-tooltip
                      content="Email"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-email-85"></i>
                    </el-tooltip>
                  </div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo !== null && row.fecha_entrega_email !== null">
                    <el-tooltip
                      content="Entregada"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-check-2"></i>
                    </el-tooltip>
                    / <el-tooltip
                      content="Enviada por Correo"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-send"></i>
                    </el-tooltip>
                    / <el-tooltip
                      content="Email"
                      effect="light"
                      :open-delay="300"
                      placement="top"
                    >
                      <i class="tim-icons icon-email-85"></i>
                    </el-tooltip>
                  </div>
                  <div v-else>No Recibida</div>
                </div>
              </el-table-column>
              <el-table-column
                label="Pago"
                :min-width="71"
                prop="forma_pago_id"
              >
                <div slot-scope="{ row }">
                  <div v-if="row.forma_pago_id == 1"> TC </div>
                  <div v-else-if="row.forma_pago_id == 2"> DC </div>
                  <div v-else> PF/RP </div>
                </div>
              </el-table-column>
              <el-table-column
                align="right"
                label="Actions"
                :min-width="115"
              >
                <div slot-scope="props">
                  <el-tooltip
                    content="Editar"
                    effect="light"
                    :open-delay="300"
                    placement="top"
                  >
                    <router-link :to="{ name: 'Editar Poliza', params: { numero_solicitud: props.row.numero_solicitud }}">
                      <base-button
                        class="edit btn-link"
                        type="warning"
                        size="sm"
                        icon
                      >
                        <i class="tim-icons icon-pencil"></i>
                      </base-button>
                    </router-link>
                  </el-tooltip>
                  <el-tooltip
                    content="Renovar"
                    effect="light"
                    :open-delay="300"
                    placement="top"
                  >
                    <base-button
                      @click.native="renovar(props.row.id)"
                      :type="'success'"
                      icon
                      size="sm"
                      class="btn-link"
                    >
                      <i class="tim-icons icon-refresh-01"></i>
                    </base-button>
                  </el-tooltip>
                  <base-button
                    @click.native="borrar(props.row.id);"
                    content="Borrar"
                    class="remove btn-link"
                    type="danger"
                    size="sm"
                    icon
                  >
                    <i class="tim-icons icon-simple-remove"></i>
                  </base-button>
                </div>
              </el-table-column>
            </el-table>
          </div>
          <div
            slot="footer"
            class="col-12 d-flex justify-content-center justify-content-sm-between flex-wrap"
          >
            <div class>
              <p class="card-category">Showing {{ from + 1 }} to {{ to }} of {{ total }} entries</p>
            </div>
            <el-select
              class="select-primary mb-3 pagination-select"
              v-model="pagination.perPage"
              placeholder="Per page"
            >
              <el-option
                class="select-primary"
                v-for="item in pagination.perPageOptions"
                :key="item"
                :label="item"
                :value="item"
              ></el-option>
            </el-select>
            <base-pagination
              class="pagination-no-border"
              v-model="pagination.currentPage"
              :per-page="pagination.perPage"
              :total="total"
            ></base-pagination>
          </div>
        </card>
      </div>
    </div>
    <modal-renovar-automotor
      v-show="isModalVisibleModalRenovarAutomotor"
      @close="closeModalRenovarAutomotor"
      :poliza="poliza"
      v-if="dataLoaded"
    />
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination, CollapseItem, Collapse } from 'src/components';
import { mixin } from '../../mixins/mixin.js';
import http from '../../API/http-request.js';
import { format } from 'date-fns';
import ModalRenovarAutomotor from './Riesgos/Automotor/ ModalRenovarAutomotor';
import { EventBus } from '../../main.js';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    Collapse,
    CollapseItem,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    ModalRenovarAutomotor
  },

  data() {
    return {
      isModalVisibleModalRenovarAutomotor: false,
      companias: {},
      clientes: {},
      estados: {},
      forma_pagos: {},
      dataLoaded: false,
      poliza: {}
    };
  },
  methods: {
    cargaPolizas() {
      let polizas = [];
      http
        .load('polizas')
        .then(r => {
          polizas = r.data.data;
          polizas.forEach(poliza => {
            poliza.vigencia_desde = format(poliza.vigencia_desde, 'DD/MM/YYYY');
          });
          polizas.forEach(poliza => {
            poliza.vigencia_hasta = format(poliza.vigencia_hasta, 'DD/MM/YYYY');
          });
          this.tableData = polizas;
        })
        .catch(e => console.log(e));
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('polizas', id).then(() => {
            this.notifyVue('danger', 'La poliza ha sido eliminada');
            this.cargaPolizas();
          });
        }
      });
    },
    cargarCompanias() {
      http.load('administracion/companias').then(response => {
        this.companias = response.data.data;
      });
    },
    cargarClientes() {
      http.load('clientes').then(response => {
        this.clientes = response.data.data;
      });
    },
    cargarEstadoPolizas() {
      http.load('estadopolizas').then(response => {
        this.estados = response.data.data;
      });
    },
    cargarFormaPagos() {
      http.load('formapagos').then(response => {
        this.forma_pagos = response.data.data;
      });
    },
    closeModalRenovarAutomotor() {
      this.vaciarForm();
      this.isModalVisibleModalRenovarAutomotor = false;
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    },
    showModalRenovarAutomotor() {
      this.vaciarForm();
      this.isModalVisibleModalRenovarAutomotor = true;
    },
    renovar(id) {
      http.loadOne('polizas', id).then(r => {
        this.poliza = r.data.data[0];
      });
      this.dataLoaded = true;
      this.showModalRenovarAutomotor();
    }
  },
  created() {
    this.cargaPolizas();
    this.cargarCompanias();
    this.cargarClientes();
    this.cargarEstadoPolizas();
    this.cargarFormaPagos();
  }
};
</script>
<style>
.card-collapse .card .card-body {
  padding-top: 0px;
  padding-left: 0px;
  padding-right: 0px;
}
.card-collapse .card .card-header {
  padding-top: 0px;
  padding-bottom: 3px;
  padding-left: 0px;
}
.card-collapse .card {
  align-items: left;
}
.card-collapse .card .card-header a i {
  margin-left: 5px;
  padding-top: 3px;
}

.card-collapse .card .card-header a[data-toggle='collapse'] i {
  float: left;
  position: absolute;
  color: gray;
}
.card-collapse .card .card-header a[data-toggle='collapse'] {
  font-size: 10px;
}
.botoncrear {
  align-self: center;
  text-align: right;
}
.botonbuscar {
  text-align: center;
}
</style>

