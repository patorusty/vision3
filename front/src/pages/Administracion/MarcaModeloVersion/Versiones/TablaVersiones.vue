<template>
  <div>
    <div
      class="col-12 row justify-content-center justify-content-sm-between flex-wrap"
    >
      <div class="row justify-content-start ml-1">
        <div class="col-md-4">
          <el-select
            v-model="marca_id"
            class="select-primary"
            @change="filtrarModelosDeMarca"
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
            @change="filtrarVersionesDeModelo"
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
          @click="showModal"
          >Crear</base-button
        >
      </div>
    </div>
    <el-table :data="queriedData">
      <el-table-column
        label="Marca"
        prop="automotor_modelo.automotor_marca.nombre"
        :min-width="30"
      ></el-table-column>
      <el-table-column
        label="Modelo"
        prop="automotor_modelo.nombre"
        :min-width="80"
      ></el-table-column>
      <el-table-column
        label="Version"
        prop="nombre"
        :min-width="80"
      ></el-table-column>
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
    <modal-versiones
      v-if="modalListo"
      v-show="isModalVisible"
      :modo="modoEditar"
      @close="closeModal"
      @crear="crear"
      :version="version"
      @recargar="cargarMarcas"
      :marca="marca_id"
      :modeloSeleccionado="modeloSeleccionado"
      :marcaSeleccionada="marcaSeleccionada"
    >
    </modal-versiones>
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import { BaseAlert } from 'src/components';
import http from '../../../../API/http-request.js';
import { mixin } from '../../../../mixins/mixin.js';
import { EventBus } from '../../../../main.js';
import ModalVersiones from './ModalVersiones';

export default {
  mixins: [mixin],
  name: 'tabla-versiones',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseAlert,
    BasePagination,
    ModalVersiones
  },
  data() {
    return {
      url: 'administracion/versiones',
      marcas: {},
      marca_id: '',
      modelos: [],
      modelo_id: '',
      version: {},
      modelo: {},
      modeloSeleccionado: {},
      marcaSeleccionada: {},
      modalListo: false,
    };
  },
  methods: {
    cargarMarcas() {
      http.load('administracion/marcas').then(r => {
        this.marcas = r.data.data;
      });
    },
    buscarMarca() {
      http.loadOne('administracion/marcas', this.marca_id).then(r => {
        this.marcaSeleccionada = r.data.data;
      });
    },
    filtrarModelosDeMarca() {
      this.modelo_id = '';
      this.tableData = [];
      http
        .loadOne('/modelos/filtrar', this.marca_id)
        .then(r => (this.modelos = r.data.data))
        .then(this.buscarMarca());
    },
    filtrarVersionesDeModelo() {
      http.loadOne('/versiones/filtrar', this.modelo_id).then(r => {
        this.tableData = r.data.data;
        this.modeloSeleccionado = this.tableData[0];
        this.modalListo = true;
      });
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
      this.version = {};
      this.modoEditar = false;
    },
    showModal() {
      this.vaciarForm();
      this.isModalVisible = true;
    },
    closeModal() {
      this.vaciarForm();
      this.isModalVisible = false;
    },
    editar(url, id) {
      this.showModal();
      this.modoEditar = true;
      http.loadOne(this.url, id).then(r => {
        this.version = r.data.data;
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete(this.url, id).then(() => {
            this.notifyVue('danger', 'La version ha sido eliminado');
            this.cargarMarcas();
          });
        }
      });
    },
    crear(value) {
      this.closeModal();
      http.create(this.url, value).then(() => {
        this.notifyVue('success', 'La version ha sido creado con exito');
        this.cargarMarcas();
      });
    }
  },
  created() {
    this.cargarMarcas();
  }
};
</script>
