<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <div>
            <div
              class="col-12 d-flex justify-content-center justify-content-sm-between flex-wrap"
            >
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
              <router-link slot="header" to="/administracion/companias/create">
                <base-button
                  class="animation-on-hover pull-right"
                  type="primary"
                  >Crear</base-button
                >
              </router-link>
            </div>
            <el-table :data="queriedData">
              <el-table-column
                label="Nombre"
                prop="nombre"
                sortable
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Telefono"
                prop="telefono_1"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Tel. Auxilio"
                prop="telefono_aux"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Tel. Siniestro"
                prop="telefono_siniestros"
                :min-width="100"
              ></el-table-column>
              <el-table-column label="Activo" prop="activo">
                <div slot-scope="{ row }">
                  <div v-if="row.activo == 1">SI</div>
                  <div v-else>NO</div>
                </div>
              </el-table-column>
              <el-table-column align="right" label="Actions">
                <div slot-scope="props">
                  <base-button
                    @click.native="editar(props.row.nombre)"
                    class="edit btn-link"
                    type="warning"
                    size="sm"
                    icon
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
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
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination, BaseAlert } from 'src/components';
import http from '../../../API/http-request.js';
import { mixin } from '../../../mixins/mixin.js';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    BaseAlert
  },
  data() {
    return {
      url: 'administracion/companias'
    };
  },
  methods: {
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete(this.url, id).then(() => {
            this.notifyVue('danger', 'La compania ha sido eliminada');
            this.cargar();
          });
        }
      });
    },
    editar(nombre) {
      this.$router.push({
        path: `/administracion/companias/${nombre}/edit`
      });
    },
    cargar() {
      http.load(this.url).then(r => (this.tableData = r.data.data));
    }
  },
  created() {
    this.cargar();
  }
};
</script>
