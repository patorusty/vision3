<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <div>
            <div
              class="col-12 row justify-content-center justify-content-sm-between flex-wrap"
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
              <div>
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
                label="Apellido"
                prop="apellido"
                sortable
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Nombre"
                prop="nombre"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Cuit"
                prop="cuit"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Email"
                prop="email"
                :min-width="100"
              ></el-table-column>
              <el-table-column
                label="Celular"
                prop="telefono_2"
                :min-width="80"
              ></el-table-column>
              <el-table-column label="Activo" prop="activo">
                <div slot-scope="{ row }">
                  <div v-if="row.activo == 1">SI</div>
                  <div v-else>NO</div>
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
    <modal-organizadores
      v-show="isModalVisible"
      :organizador="organizador"
      :modo="modoEditar"
      @close="closeModal"
      @crear="crear"
      @recargar="cargar"
    ></modal-organizadores>
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import http from '../../../API/http-request.js';
import ModalOrganizadores from './ModalOrganizadores';
import { BaseAlert } from 'src/components';
import { mixin } from '../../../mixins/mixin.js';
import { EventBus } from '../../../main.js';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    ModalOrganizadores,
    BaseAlert
  },
  data() {
    return {
      organizador: {},
      url: 'administracion/organizadores'
    };
  },
  methods: {
    cargar() {
      http.load(this.url).then(r => (this.tableData = r.data.data));
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
      this.organizador = {
        activo: true
      };
    },
    showModal() {
      this.vaciarForm();
      this.$validator.reset();
      this.errors.clear();
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.vaciarForm();
      this.$validator.reset();
      this.errors.clear();
    },
    crear(value) {
      this.showModal();
      http
        .create(this.url, value)
        .then(() => {
          this.notifyVue('success', 'El organizador ha sido creado con exito');
          this.cargar();
          this.closeModal();
        })
        .catch(e => console.log(e));
    },
    editar(url, id) {
      this.showModal();
      this.modoEditar = true;
      http
        .loadOne(this.url, id)
        .then(r => {
          this.organizador = r.data.data;
        })
        .catch(e => console.log(e));
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete(this.url, id).then(() => {
            this.notifyVue('danger', 'El organizador ha sido eliminado');
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
