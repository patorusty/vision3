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
            </div>
            <el-table :data="queriedData">
              <el-table-column
                label="Poliza N°"
                :min-width="90"
              >
                <div slot-scope="{ row }">{{ row.polizas.numero }}</div>
              </el-table-column>
              <el-table-column
                label="Endoso N°"
                :min-width="80"
                prop="numero_endoso"
              >
              </el-table-column>
              <el-table-column
                label="Tipo"
                :min-width="90"
              >
                <div slot-scope="{ row }">{{ row.tipo_endosos.nombre }}</div>
              </el-table-column>
              <el-table-column
                label="Asegurado"
                :min-width="128"
              >
                <div slot-scope="{ row }">
                  <router-link
                    v-if="row.polizas.clientes.razon_social === null"
                    to="#"
                  >{{ row.polizas.clientes.apellido }} <br> {{ row.polizas.clientes.nombre }}</router-link>
                  <router-link
                    v-else
                    to="#"
                  >{{ row.polizas.clientes.razon_social }}</router-link>
                </div>
              </el-table-column>
              <el-table-column
                label="Compañia"
                :min-width="70"
              >
                <div slot-scope="{ row }">
                  {{ row.polizas.companias.nombre }}
                </div>
              </el-table-column>
              <el-table-column
                label="F. Solicitud"
                :min-width="90"
                prop="fecha_solicitud"
              ></el-table-column>

              <el-table-column
                label="Completo"
                :min-width="65"
              >
                <div slot-scope="{ row }">
                  <div v-if="row.completo == true">SI</div>
                  <div v-else>NO</div>
                </div>
              </el-table-column>
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
                    <base-button
                      @click.native="
                        editar(props.row.id, props.row.tipo_endoso_id)
                      "
                      class="edit btn-link"
                      type="warning"
                      size="sm"
                      icon
                    >
                      <i class="tim-icons icon-pencil"></i>
                    </base-button>
                  </el-tooltip>
                  <base-button
                    @click.native="borrar(props.row.id)"
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
              <p class="card-category">
                Showing {{ from + 1 }} to {{ to }} of {{ total }} entries
              </p>
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
    <modal-endoso-editar
      v-if="dataLoaded"
      v-show="isModalVisibleEndosoEditar"
      @close="closeModalEndosoEditar"
      :endoso="endoso"
      @recargar="cargarEndosos"
    />
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import { mixin } from '../../../mixins/mixin.js';
import http from '../../../API/http-request.js';
import { format } from 'date-fns';
import ModalEndosoEditar from './ModalEndosoEditar';
import { EventBus } from '../../../main.js';
import { BaseAlert } from 'src/components';
import { BaseSwitch } from 'src/components/index';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    ModalEndosoEditar,
    BaseAlert,
    BaseSwitch
  },

  data() {
    return {
      isModalVisibleEndosoEditar: false,
      url: 'endosos',
      endoso: {},
      riesgo: {},
      tableData: [],
      dataLoaded: false
    };
  },
  methods: {
    cargarEndosos() {
      let endosos = [];
      http
        .load('endosos')
        .then(r => {
          endosos = r.data.data;
          endosos.forEach(endoso => {
            endoso.fecha_solicitud = format(
              endoso.fecha_solicitud,
              'DD/MM/YYYY'
            );
          });
          this.tableData = endosos;
          // this.dataLoaded = true;
        })
        .catch(e => console.log(e));
    },
    closeModalEndosoEditar() {
      this.vaciarForm();
      this.isModalVisibleEndosoEditar = false;
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    },
    showModalEndosoEditar() {
      this.vaciarForm();
      this.isModalVisibleEndosoEditar = true;
    },
    editar(id, tipo_endoso_id) {
      http.loadOne('endosos', id).then(r => {
        this.endoso = r.data.data;
      });
      this.dataLoaded = true;
      this.$nextTick(() => {
        EventBus.$emit('filtrarTipos', tipo_endoso_id);
      });
      this.showModalEndosoEditar(tipo_endoso_id);
    },
    borrar(url, id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('endosos', id).then(() => {
            this.notifyVue('danger', 'El endoso ha sido eliminada');
            this.cargarEndosos();
          });
        }
      });
    }
  },
  created() {
    this.cargarEndosos();
  }
};
</script>
