<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <div>
            <div class="col-12 d-flex justify-content-center justify-content-sm-between flex-wrap">
              <base-input>
                <el-input
                  type="search"
                  class="mb-3 search-input"
                  clearable
                  prefix-icon="el-icon-search"
                  placeholder="Buscar"
                  v-model="searchQuery"
                  aria-controls="datatables"
                ></el-input>
              </base-input>
              <router-link
                slot="header"
                to="/polizas/automotor/create"
              >
                <base-button
                  class="animation-on-hover pull-right"
                  type="primary"
                >Crear</base-button>
              </router-link>
            </div>
            <el-table :data="queriedData">
              <el-table-column
                label="Poliza"
                prop="numero"
                sortable
                :min-width="50"
              ></el-table-column>
              <!-- <el-table-column label="Patente"></el-table-column> -->
              <el-table-column label="Compania">
                <div slot-scope="{ row }">{{row.companias.nombre}} ({{row.codigo_productor.codigo_productor}})</div>
              </el-table-column>
              <el-table-column
                label="Cliente"
                sortable
                :min-width="100"
              >
                <div slot-scope="{ row }">
                  <router-link
                    v-if="row.clientes.razon_social === null"
                    to="#"
                  >{{ row.clientes.nombre }} {{ row.clientes.apellido }}</router-link>
                  <router-link
                    v-else
                    to="#"
                  >{{ row.clientes.razon_social }}</router-link>
                </div>
              </el-table-column>
              <el-table-column
                label="Vigencia"
                :min-width="60"
                prop="tipo_vigencias.vigencia"
              ></el-table-column>
              <el-table-column
                label="Desde / Hasta"
                :min-width="90"
              >
                <div slot-scope="{ row }">{{row.vigencia_desde}} / {{row.vigencia_hasta}}</div>
              </el-table-column>
              <el-table-column
                label="Estado"
                prop="estado_polizas.nombre"
                :min-width="100"
              ></el-table-column>
              <el-table-column label="Envio">
                <div slot-scope="{ row }">
                  <div v-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo === null && row.fecha_entrega_email === null">Recibida</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo === null && row.fecha_entrega_email === null">Entregada</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo !== null && row.fecha_entrega_email === null">Correo</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo === null && row.fecha_entrega_email !== null">Email</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo !== null && row.fecha_entrega_email === null">Entregada / Correo</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo === null && row.fecha_entrega_email !== null">Entregada / Email</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original === null && row.fecha_entrega_correo !== null && row.fecha_entrega_email !== null">Correo / Email</div>
                  <div v-else-if="row.fecha_recepcion !== null && row.fecha_entrega_original !== null && row.fecha_entrega_correo !== null && row.fecha_entrega_email !== null">Entregada / Correo / Email</div>
                  <div v-else>No recibida</div>
                </div>
              </el-table-column>
              <el-table-column
                label="F. Pago"
                prop="medio_pago"
                :min-width="50"
              ></el-table-column>
              <el-table-column
                align="right"
                label="Actions"
              >
                <div slot-scope="props">
                  <el-tooltip
                    content="Editar"
                    effect="light"
                    :open-delay="300"
                    placement="top"
                  >
                    <router-link :to="{ name: 'Editar Poliza Automotor', params: { numero_solicitud: props.row.numero_solicitud }}">
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
                    @click.native="handleDelete(props.$index, props.row);"
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
import { BasePagination } from 'src/components';
import { mixin } from '../../mixins/mixin.js';
import http from '../../API/http-request.js';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn
  },

  data() {
    return {};
  },
  methods: {
    cargaPolizas() {
      http
        .load('http://127.0.0.1:8000/api/polizas')
        .then(r => {
          this.dataLoaded = true;
          this.tableData = r.data.data;
        })
        .catch(e => console.log(e));
    }
  },
  created() {
    this.cargaPolizas();
  }
};
</script>
