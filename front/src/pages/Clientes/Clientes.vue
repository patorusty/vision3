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
              <router-link slot="header" to="clientes/create">
                <base-button
                  class="animation-on-hover pull-right"
                  type="primary"
                  >Crear</base-button
                >
              </router-link>
            </div>
            <el-table :data="queriedData">
              <el-table-column label="Nombre" :min-width="100" prop="apellido">
                <div slot-scope="{ row }">
                  {{ row.apellido }} {{ row.nombre }}
                </div>
              </el-table-column>
              <el-table-column
                label="DNI"
                prop="nro_dni"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Celular"
                prop="celular"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Email"
                prop="email"
                :min-width="120"
              ></el-table-column>
              <el-table-column label="Productor" :min-width="70">
                <div slot-scope="{ row }">
                  {{ row.productores.apellido }} {{ row.productores.nombre }}
                </div>
              </el-table-column>
              <el-table-column align="right" label="Actions">
                <div slot-scope="props">
                  <el-tooltip
                    content="Editar"
                    effect="light"
                    :open-delay="300"
                    placement="top"
                  >
                    <base-button
                      @click.native="editar(url, props.row.id)"
                      class="edit btn-link"
                      type="warning"
                      size="sm"
                      icon
                    >
                      <i class="tim-icons icon-pencil"></i>
                    </base-button>
                  </el-tooltip>
                  <el-tooltip
                    content="Eliminar"
                    effect="light"
                    :open-delay="300"
                    placement="top"
                  >
                    <base-button
                      @click.native="borrar(props.row.id)"
                      class="remove btn-link"
                      type="danger"
                      size="sm"
                      icon
                    >
                      <i class="tim-icons icon-simple-remove"></i>
                    </base-button>
                  </el-tooltip>
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
    cargar() {
      http.load('clientes').then(r => {
        this.dataLoaded = true;
        this.tableData = r.data.data;
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('clientes', id).then(() => {
            this.notifyVue('danger', 'El cliente ha sido eliminado');
            this.cargar();
          });
        }
      });
    }
  },
  created() {
    this.cargar();
  }
};
</script>
