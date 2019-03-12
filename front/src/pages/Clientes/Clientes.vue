<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <router-link slot="header" to="">
            <base-button class="animation-on-hover pull-right" type="primary"
              >Crear</base-button
            >
          </router-link>
          <div>
            <div
              class="col-12 d-flex justify-content-center justify-content-sm-between flex-wrap"
            >
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
                label="Apellido / Nombre"
                sortable
                :min-width="80"
              >
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
                :min-width="100"
              ></el-table-column>
              <el-table-column label="Productor" :min-width="80">
                <div slot-scope="{ row }">
                  {{ row.productores.apellido }} {{ row.productores.nombre }}
                </div>
              </el-table-column>
              <el-table-column align="right" label="Actions">
                <div slot-scope="props">
                  <base-button
                    @click.native="handleLike(props.$index, props.row)"
                    class="remove btn-link"
                    type="info"
                    size="sm"
                    icon
                  >
                    <i class="tim-icons icon-heart-2"></i>
                  </base-button>
                  <base-button
                    @click.native="handleEdit(props.$index, props.row)"
                    class="edit btn-link"
                    type="warning"
                    size="sm"
                    icon
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                  <base-button
                    @click.native="handleDelete(props.$index, props.row)"
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
              Ï
            </div>
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
import Fuse from 'fuse.js';
import axios from 'axios';

export default {
  components: {
    BasePagination,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn
  },
  computed: {
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
    queriedData() {
      let result = this.tableData;
      if (this.searchedData.length > 0) {
        result = this.searchedData;
      }
      return result.slice(this.from, this.to);
    },
    to() {
      let highBound = this.from + this.pagination.perPage;
      if (this.total < highBound) {
        highBound = this.total;
      }
      return highBound;
    },
    from() {
      return this.pagination.perPage * (this.pagination.currentPage - 1);
    },
    total() {
      return this.searchedData.length > 0
        ? this.searchedData.length
        : this.tableData.length;
    }
  },
  data() {
    return {
      pagination: {
        perPage: 5,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      searchQuery: '',
      propsToSearch: [],
      tableData: [],
      searchedData: [],
      fuseSearch: null
    };
  },
  methods: {
    cargaPolizas() {
      axios.get('http://127.0.0.1:8000/api/clientes/').then(response => {
        console.log(response.data.data);
        this.dataLoaded = true;
        this.tableData = response.data.data;
      });
    }
  },
  mounted() {
    this.fuseSearch = new Fuse(this.tableData, {
      keys: [],
      threshold: 0.3
    });

    this.cargaPolizas();
  },
  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    searchQuery(value) {
      let result = this.tableData;
      if (value !== '') {
        result = this.fuseSearch.search(this.searchQuery);
      }
      this.searchedData = result;
    }
  }
};
</script>
