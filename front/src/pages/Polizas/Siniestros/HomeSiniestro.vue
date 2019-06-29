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
                label="Siniestro N°"
                :min-width="90"
                prop="numero_siniestro"
              >
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
                label="F. Siniestro"
                :min-width="70"
                prop="fecha_siniestro"
              ></el-table-column>
              <el-table-column
                label="Completo"
                :min-width="60"
              >
                <div slot-scope="{ row }">
                  <div v-if="row.fecha_completo == null">NO</div>
                  <div v-else>SI</div>
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
                      @click.native="editar(props.row.id)"
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
    <modal-siniestros-editar
      v-show="isModalVisibleSiniestroEditar"
      @close="closeModalSiniestroEditar"
      :siniestro="siniestro"
      v-if="dataLoaded"
      @recargar="cargarSiniestros"
    />
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import { mixin } from '../../../mixins/mixin.js';
import http from '../../../API/http-request.js';
import { format } from 'date-fns';
import ModalSiniestrosEditar from './ModalSiniestroEditar';
import NotasSiniestro from './NotasSiniestro';
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
    ModalSiniestrosEditar,
    NotasSiniestro,
    BaseAlert,
    BaseSwitch
  },

  data() {
    return {
      isModalVisibleSiniestroEditar: false,
      url: 'siniestrosautomotor',
      siniestro: {},
      tableData: [],
      dataLoaded: false
    };
  },
  methods: {
    cargarSiniestros() {
      let siniestros = [];
      http
        .load('siniestrosautomotor')
        .then(r => {
          siniestros = r.data.data;
          siniestros.forEach(siniestro => {
            siniestro.fecha_denuncia = format(
              siniestro.fecha_denuncia,
              'DD/MM/YYYY'
            );
          });
          siniestros.forEach(siniestro => {
            siniestro.fecha_siniestro = format(
              siniestro.fecha_siniestro,
              'DD/MM/YYYY'
            );
          });
          this.tableData = siniestros;
          this.dataLoaded = true;
        })
        .catch(e => console.log(e));
    },
    closeModalSiniestroEditar() {
      this.vaciarForm();
      this.isModalVisibleSiniestroEditar = false;
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    },
    showModalSiniestroEditar() {
      this.vaciarForm();
      this.isModalVisibleSiniestroEditar = true;
    },
    editar(id) {
      this.showModalSiniestroEditar(id);
      http.loadOne('siniestrosautomotor', id).then(r => {
        this.siniestro = r.data.data;
        this.$nextTick(() => {
          EventBus.$emit('cargarNotas', id);
        });
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('siniestrosautomotor', id).then(() => {
            this.notifyVue('danger', 'El siniestro ha sido eliminada');
            this.cargarSiniestros();
          });
        }
      });
    }
  },
  created() {
    this.cargarSiniestros();
  }
};
</script>
