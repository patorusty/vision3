<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <div class="">
            <div class="row">
              <div class="col-md-10">
                <div class="row">
                  <div class="col-md-4">
                    <label>Asegurado:</label>
                    <el-select
                      filterable
                      name="cliente_id"
                      class="select-primary"
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
                  </div>
                  <div class="col-md-3">
                    <base-input>
                      <label>Poliza N:</label>
                      <el-input
                        type="search"
                        class="search-input"
                        clearable
                        prefix-icon="el-icon-search"
                        placeholder="Buscar"
                        v-model="searchQuery"
                        aria-controls="datatables"
                      ></el-input>
                    </base-input>
                  </div>
                  <div class="col-md-3">
                    <base-input>
                      <label>Patente:</label>
                      <el-input
                        type="search"
                        class="search-input"
                        clearable
                        prefix-icon="el-icon-search"
                        placeholder="Buscar"
                        v-model="searchQuery"
                        aria-controls="datatables"
                      ></el-input>
                    </base-input>
                  </div>
                </div>
                <collapse :active-index="1">
                  <collapse-item
                    title="Busqueda avanzada"
                    class="style=padding:0px"
                  >
                    <div class="
                    row">
                      <div class="col-md-3">
                        <label>Compañia</label>
                        <el-select
                          name="compania"
                          class="select-primary"
                          filterable
                        >
                          <el-option
                            class="select-primary"
                            v-for="compania in companias"
                            :key="compania.id"
                            :value="compania.id"
                            :label="compania.nombre"
                          ></el-option>
                        </el-select>
                      </div>
                      <div class="col-md-3">
                        <base-input>
                          <label>Estado:</label>
                          <el-input
                            type="search"
                            class="search-input"
                            clearable
                            prefix-icon="el-icon-search"
                            placeholder="Buscar"
                            v-model="searchQuery"
                            aria-controls="datatables"
                          ></el-input>
                        </base-input>
                      </div>
                      <div class="col-md-3">
                        <base-input>
                          <label>Cobertura:</label>
                          <el-input
                            type="search"
                            class="search-input"
                            clearable
                            prefix-icon="el-icon-search"
                            placeholder="Buscar"
                            v-model="searchQuery"
                            aria-controls="datatables"
                          ></el-input>
                        </base-input>
                      </div>
                      <div class="col-md-3">
                        <base-input>
                          <label>Forma de Pago:</label>
                          <el-input
                            type="search"
                            class="search-input"
                            clearable
                            prefix-icon="el-icon-search"
                            placeholder="Buscar"
                            v-model="searchQuery"
                            aria-controls="datatables"
                          ></el-input>
                        </base-input>
                      </div>
                    </div>
                  </collapse-item>
                </collapse>
                <div class="botonbuscar">
                  <base-button type="primary">Buscar
                  </base-button>
                </div>
              </div>
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
                label="Poliza"
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
                label="Cliente"
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
                prop="medio_pago"
                :min-width="71"
              ></el-table-column>
              <el-table-column
                align="right"
                label="Actions"
                :width="94"
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
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination, CollapseItem, Collapse } from 'src/components';
import { mixin } from '../../mixins/mixin.js';
import http from '../../API/http-request.js';
import { format } from 'date-fns';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    Collapse,
    CollapseItem,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn
  },

  data() {
    return {
      companias: {},
      clientes: {}
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
    }
  },
  created() {
    this.cargaPolizas();
    this.cargarCompanias();
    this.cargarClientes();
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

