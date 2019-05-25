<template>
  <div class="col-md-6">
    <card class="mt-4 ">
      <div
        class="col-sm-12 row align-items-center"
        slot="header"
      >
        <div class="col">
          <h4 class="d-inline text-primary ">ENDOSOS</h4>
          <base-button
            type="primary"
            size="sm"
            class="float-right"
            @click="showModalEndoso"
          >+</base-button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <el-table :data="queriedData">
            <el-table-column
              min-width="100"
              align="left"
              label="Fecha"
              prop="fecha_solicitud"
            >
            </el-table-column>
            <el-table-column
              min-width="132"
              label="Tipo"
              align="left"
            >
              <div slot-scope="{ row }">
                {{ row.tipo_endosos.nombre }}
              </div>
            </el-table-column>
            <el-table-column
              min-width="150"
              label="Detalle"
              align="left"
            >
              <div slot-scope="{ row }">
                {{ row.detalle_endosos.nombre }}
              </div>
            </el-table-column>
            <el-table-column
              min-width="85"
              align="left"
              label="Compl."
            >
              <div slot-scope="{ row }">
                <div v-if="row.completo == true">SI</div>
                <div v-else>NO</div>
              </div>
            </el-table-column>
            <el-table-column
              min-width="90"
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
                    @click.native="editar(props.row.id, props.row.tipo_endoso_id)"
                    type="warning"
                    icon
                    size="sm"
                    class="edit btn-link"
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                </el-tooltip>
                <el-tooltip
                  @click.native="borrar(props.row.id)"
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
    <modal-endoso
      v-show="isModalVisibleEndoso"
      @close="closeModalEndoso"
      @crear="crear"
    />
    <modal-endoso-editar
      v-show="isModalVisibleEndosoEditar"
      @close="closeModalEndosoEditar"
      :endoso="endoso"
      v-if="dataLoaded"
      @recargar="cargar"
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
import ModalEndoso from './ModalEndoso';
import ModalEndosoEditar from './ModalEndosoEditar';
import { format } from 'date-fns';

export default {
  mixins: [mixin],
  name: 'tabla-endosos',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseSwitch,
    BaseAlert,
    BasePagination,
    ModalEndoso,
    ModalEndosoEditar
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
      url: 'endosos/poliza_id',
      isModalVisibleEndoso: false,
      isModalVisibleEndosoEditar: false,
      endoso: {},
      tableData: [],
      dataLoaded: false
    };
  },
  methods: {
    cargar() {
      let endosos = [];
      http.loadOne(this.url, this.poliza.id).then(r => {
        endosos = r.data.data;
        endosos.forEach(endoso => {
          endoso.fecha_solicitud = format(endoso.fecha_solicitud, 'DD/MM/YYYY');
        });
        this.tableData = endosos;
        this.dataLoaded = true;
      });
    },
    crear(value) {
      value.poliza_id = this.poliza.id;
      this.closeModalEndoso();
      http.create('endosos', value).then(() => {
        this.notifyVue('success', 'El endoso ha sido creado con exito');
        this.cargar();
      });
    },

    showModalEndoso() {
      this.vaciarForm();
      this.isModalVisibleEndoso = true;
    },
    closeModalEndoso() {
      this.vaciarForm();
      this.isModalVisibleEndoso = false;
    },
    closeModalEndosoEditar() {
      this.vaciarForm();
      this.isModalVisibleEndosoEditar = false;
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    },
    showModalEndosoEditar(tipo_endoso_id) {
      this.vaciarForm();
      EventBus.$emit('filtrarTipos', tipo_endoso_id);
      this.isModalVisibleEndosoEditar = true;
    },
    editar(id, tipo_endoso_id) {
      console.log(tipo_endoso_id);
      this.showModalEndosoEditar(tipo_endoso_id);
      http.loadOne('endosos', id).then(r => {
        this.endoso = r.data.data;
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('endosos', id).then(() => {
            this.notifyVue('danger', 'El endoso ha sido eliminado');
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
