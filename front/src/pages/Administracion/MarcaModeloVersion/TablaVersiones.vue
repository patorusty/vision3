<template>
  <div>
    <div class="col-12 row justify-content-center justify-content-sm-between flex-wrap">
      <div class="row justify-content-start ml-1">
        <div class="col-md-4">
          <el-select
            v-model="marca_id"
            class="select-primary"
            @change="filtrarMarca"
            filterable
          >
            <el-option
              v-for="marca in marcas"
              :key="marca.id"
              :value="marca.id"
              :label="marca.nombre"
              class="select-primary"
            >
            </el-option>
          </el-select>
        </div>
        <div class="col-md-4">
          <el-select
            v-model="modelo_id"
            class="select-primary"
            @change="filtrarVersion"
            filterable
          >
            <el-option
              v-for="modelo in modelos"
              :key="modelo.id"
              :value="modelo.id"
              :label="modelo.nombre"
              class="select-primary"
            >
            </el-option>
          </el-select>
        </div>
        <div class="col-md-4">
          <base-input>
            <el-input
              type="search"
              class="mb-3 search-input"
              clearable
              prefix-icon="el-icon-search"
              placeholder="Buscar"
              v-model="searchQuery"
              aria-controls="datatables"
            >
            </el-input>
          </base-input>
        </div>
      </div>
      <div class="mr-3">
        <base-button
          slot="header"
          class="animation-on-hover "
          type="primary"
        >Crear</base-button>
      </div>
    </div>
    <el-table :data="queriedData">
      <el-table-column
        label="Marca"
        prop="automotor_marca.automotor_modelo.nombre"
        :min-width="80"
      ></el-table-column>
      <el-table-column
        label="Modelo"
        prop="automotor_modelo.nombre"
        :min-width="80"
      ></el-table-column>
      <el-table-column
        label="Nombre"
        prop="nombre"
        :min-width="80"
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
  </div>

</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import { BaseAlert } from 'src/components';
import { BaseSwitch } from 'src/components/index';
import http from '../../../API/http-request.js';
import { mixin } from '../../../mixins/mixin.js';
import { EventBus } from '../../../main.js';

export default {
  mixins: [mixin],
  name: 'tabla-versiones',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseAlert,
    BasePagination
  },
  data() {
    return {
      url: 'administracion/versiones',
      automotor_marcas: {},
      marcas: {},
      marca_id: '',
      automotor_modelos: {},
      modelos: {},
      modelo_id: '',
      versiones: [],
      version_id: ''
    };
  },
  methods: {
    cargarMarcas() {
      http.load('administracion/marcas', this.marca_id).then(r => {
        this.marcas = r.data.data;
      });
    },
    filtrarMarca() {
      http
        .loadOne('/modelos/filtrar', this.marca_id)
        .then(r => (this.modelos = r.data.data));
    },
    filtrarVersion() {
      http
        .loadOne('/versiones/filtrar', this.modelo_id)
        .then(r => (this.tableData = r.data.data));
    }
  },
  created() {
    this.cargarMarcas();
  }
};
</script>



