<template>
  <card>
    <div
      class="col-sm-12"
      slot="header"
    >
      <h4 class="d-inline align-bottom text-primary">COBERTURAS</h4>
      <base-button
        type="primary"
        size="sm"
        class="float-right"
        @click="showModal"
      >Crear</base-button>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <el-table :data="queriedData">
          <el-table-column
            min-width="80"
            prop="nombre"
            label="Nombre"
            align="left"
          >
          </el-table-column>
          <el-table-column
            min-width="80"
            prop="antiguedad"
            label="Antiguedad"
            align="left"
          >
          </el-table-column>
          <el-table-column
            min-width="80"
            align="left"
            label="Todo Riesgo"
          >
            <div slot-scope="{ row }">
              <div v-if="row.todo_riesgo == true">SI</div>
              <div v-else>NO</div>
            </div>
          </el-table-column>
          <el-table-column
            min-width="80"
            prop="franquicia"
            align="left"
            label="Franquicia"
          >
          </el-table-column>
          <el-table-column
            min-width="80"
            prop="ajuste"
            align="left"
            label="Ajuste"
          >
          </el-table-column>
          <el-table-column
            min-width="80"
            align="left"
            label="Activa"
          >
            <div slot-scope="{ row }">
              <div v-if="row.activa == true">SI</div>
              <div v-else>NO</div>
            </div>
          </el-table-column>
          <el-table-column
            min-width="150"
            header-align="right"
            align="right"
            label="Edicion"
          >
            <div
              slot-scope="props"
              class="text-right table-actions"
            >
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
    <modal-cob
      v-show="isModalVisibleCob"
      :modo="modoEditar"
      @close="closeModal"
      :cobertura="cobertura"
      @recargar="cargar"
      @crear="crear"
    />
  </card>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import { BaseAlert } from 'src/components';
import { BaseSwitch } from 'src/components/index';
import http from '../../../../API/http-request.js';
import { mixin } from '../../../../mixins/mixin.js';
import { EventBus } from '../../../../main.js';
import ModalCob from './ModalCob';
export default {
  mixins: [mixin],
  name: 'tabla-cob',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseSwitch,
    BaseAlert,
    BasePagination,
    ModalCob
  },
  props: {
    compania: {
      type: Object,
      required: true,
      default: null
    }
  },
  data() {
    return {
      url: 'cobertura/compania',
      isModalVisibleCob: false,
      cobertura: {}
    };
  },
  methods: {
    cargar() {
      http.loadOne(this.url, this.compania.id).then(r => {
        this.tableData = r.data.data;
      });
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
      this.cobertura = {
        activo: true,
        compania_id: this.compania.id
      };
      this.modoEditar = false;
    },
    showModal() {
      this.vaciarForm();
      this.isModalVisibleCob = true;
    },
    closeModal() {
      this.vaciarForm();
      this.isModalVisibleCob = false;
    },
    editar(id) {
      this.showModal();
      this.modoEditar = true;
      http.loadOne('cobertura', id).then(r => {
        this.cobertura = r.data.data;
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('cobertura', id).then(() => {
            this.notifyVue('danger', 'La cobertura ha sido eliminado');
            this.cargar();
          });
        }
      });
    },
    crear(value) {
      this.closeModal();
      http.create('cobertura', value).then(() => {
        this.notifyVue('success', 'La cobertura ha sido creado con exito');
        this.cargar();
      });
    }
  },
  mounted() {
    this.cargar();
  }
};
</script>