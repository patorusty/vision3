<template>
  <!-- ACA EMPIEZA LA TABLA DE CODIGO ORGANIZADOR -->
  <card>
    <div class="col-sm-12" slot="header">
      <h4 class="d-inline align-bottom text-primary">
        CODIGOS ORGANIZADOR
      </h4>
      <base-button
        type="primary"
        size="sm"
        class="float-right"
        @click="showModalCodigoOrg"
        >Crear</base-button
      >
    </div>
    <div class="row">
      <div class="col-sm-12">
        <el-table :data="queriedData">
          <el-table-column
            min-width="80"
            prop="name"
            label="Apellido"
            align="left"
          >
            <div slot-scope="{ row }">
              {{ row.organizadores.apellido }}
            </div>
          </el-table-column>
          <el-table-column
            min-width="80"
            prop="job"
            label="Nombre"
            align="left"
          >
            <div slot-scope="{ row }">
              {{ row.organizadores.nombre }}
            </div>
          </el-table-column>
          <el-table-column min-width="80" align="left" label="Matricula">
            <div slot-scope="{ row }">
              {{ row.organizadores.matricula }}
            </div>
          </el-table-column>
          <el-table-column
            min-width="80"
            prop="codigo_organizador"
            align="left"
            label="Cod. Organizador"
          >
          </el-table-column>
          <el-table-column min-width="80" align="left" label="Activo">
            <div slot-scope="{ row }">
              <div v-if="row.activo == true">SI</div>
              <div v-else>NO</div>
            </div>
          </el-table-column>
          <el-table-column
            min-width="80"
            header-align="right"
            align="left"
            label="Edicion"
          >
            <div slot-scope="props" class="text-right table-actions">
              <el-tooltip
                content="Editar"
                effect="light"
                :open-delay="300"
                placement="top"
              >
                <base-button
                  @click.native="handleEdit(props.row.id)"
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
                  @click.native="borrarCO(props.row.id)"
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
    <!-- <modal-co
      v-show="isModalVisibleCO"
      :organizador="organizador"
      :modo="modoEditar"
      @close="closeModal"
      @crear="crear"
      @recargar="cargar"
    /> -->
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
import ModalCo from './ModalCo';

export default {
  mixins: [mixin],
  name: 'tabla-co',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseSwitch,
    BaseAlert,
    BasePagination,
    ModalCo
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
      organizadores: {},
      url: 'codigoorganizador/compania',
      isModalVisibleCO: false
    };
  },
  methods: {
    cargar() {
      http
        .loadOne(this.url, this.compania.id)
        .then(r => {
          this.tableData = r.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    showModalCodigoOrg() {
      this.vaciarForm();
      this.isModalVisibleCO = true;
    },
    closeModalCodigoOrg() {
      this.vaciarForm();
      this.isModalVisibleCO = false;
    },
    borrarCO(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('codigoorganizador', id).then(() => {
            this.notifyVue('danger', 'El codigo organizador ha sido eliminado');
            this.cargar();
          });
        }
      });
    }
  },
  mounted() {
    this.cargar();
  }
};
</script>
