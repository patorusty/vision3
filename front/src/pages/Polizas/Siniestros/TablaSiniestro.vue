<template>
  <div class="col-md-6">
    <card class="mt-4 ">
      <div
        class="col-sm-12 row align-items-center"
        slot="header"
      >
        <div class="col">
          <h4 class="d-inline text-primary ">SINIESTROS</h4>
          <base-button
            type="primary"
            size="sm"
            class="float-right"
            @click="showModalSiniestro"
          >Siniestro +</base-button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <el-table :data="queriedData">
            <el-table-column
              min-width="100"
              align="left"
              label="F. Denuncia"
              prop="fecha_denuncia"
            >
            </el-table-column>
            <el-table-column
              min-width="100"
              label="F. Siniestro"
              align="left"
              prop="fecha_siniestro"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              label="Numero"
              align="left"
            >
            </el-table-column>
            <el-table-column
              min-width="85"
              align="left"
              label="Completo"
            >
              <div slot-scope="{ row }">
                <div v-if="row.completo == true">SI</div>
                <div v-else>NO</div>
              </div>
            </el-table-column>
            <el-table-column
              min-width="80"
              header-align="right"
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
                    @click.native="editar(props.row.poliza_id)"
                    type="warning"
                    icon
                    size="sm"
                    class="edit btn-link"
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                </el-tooltip>
                <el-tooltip
                  content="Delete"
                  effect="light"
                  :open-delay="300"
                  placement="top"
                >
                  <base-button
                    type="danger"
                    icon
                    size="sm"
                    class="btn-link"
                  >
                    <i class="tim-icons icon-simple-remove"></i>
                  </base-button>
                </el-tooltip>
              </div>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </card>
    <modal-siniestros
      v-show="isModalVisibleSiniestro"
      @close="closeModalSiniestro"
      @crear="crear"
    />
    <modal-siniestros-editar
      v-show="isModalVisibleSiniestroEditar"
      @close="closeModalSiniestroEditar"
      :siniestro="siniestro"
      v-if="dataLoaded"
      @regargar="crear"
    />
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
import ModalSiniestros from './ModalSiniestro';
import ModalSiniestrosEditar from './ModalSiniestroEditar';

export default {
  mixins: [mixin],
  name: 'tabla-siniestros',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseSwitch,
    BaseAlert,
    BasePagination,
    ModalSiniestros,
    ModalSiniestrosEditar
  },
  props: {
    poliza: {
      type: Object,
      required: true,
      default: null
    }
  },
  data() {
    return {
      isModalVisibleSiniestro: false,
      isModalVisibleSiniestroEditar: false,
      siniestro: {},
      tableData: [],
      dataLoaded: false,
      url: 'siniestrosautomotor/poliza_id'
    };
  },
  methods: {
    cargar() {
      http.loadOne(this.url, this.poliza.id).then(r => {
        this.tableData = r.data.data;
        this.dataLoaded = true;
      });
    },
    crear(value) {
      value.poliza_id = this.poliza.id;
      this.closeModalSiniestro();
      http.create('siniestrosautomotor', value).then(() => {
        this.notifyVue('success', 'El siniestro ha sido cargado con exito');
        this.cargar();
      });
    },
    showModalSiniestro() {
      this.vaciarForm();
      this.isModalVisibleSiniestro = true;
    },
    closeModalSiniestro() {
      this.vaciarForm();
      this.isModalVisibleSiniestro = false;
    },
    closeModalSiniestroEditar() {
      this.vaciarForm();
      this.isModalVisibleSiniestro = false;
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    },
    showModalSiniestroEditar(id) {
      this.vaciarForm();
      EventBus.$emit('filtrarTipos', id);
      this.isModalVisibleSiniestroEditar = true;
    },
    editar(id) {
      this.showModalSiniestroEditar(id);
      http.loadOne('siniestrosautomotor', id).then(r => {
        this.siniestro = r.data.data;
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('siniestrosautomotor', id).then(() => {
            this.notifyVue('danger', 'El siniestro ha sido eliminado');
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
