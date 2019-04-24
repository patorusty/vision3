<template>
  <div class="col-md-12">
    <card class="mt-4 ">
      <div
        class="col-sm-12 row align-items-center"
        slot="header"
      >
        <div class="col">
          <h4 class="d-inline text-primary ">DETALLE DEL RIESGO</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <el-table :data="queriedData">
            <el-table-column
              min-width="80"
              align="left"
              label="Tipo"
              prop="automotor_tipo"
            >
            </el-table-column>
            <el-table-column
              min-width="150"
              label="Marca / Modelo / Version"
              align="left"
              prop="automotor_marca.nombre"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              label="Patente"
              align="left"
              prop="patente"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Suma Asegurada"
              prop="valor_total"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Cobertura"
              prop="cobertura_id"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Franquicia"
              prop="franquicia"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              header-align="right"
              align="left"
              label="Edicion"
            >
              <div
                slot-scope="{ row, $index }"
                class="text-right table-actions"
              >
                <el-tooltip
                  content="Refresh"
                  effect="light"
                  :open-delay="300"
                  placement="top"
                >
                  <base-button
                    @click.native="editar(url, props.row.id)"
                    :type="$index > 2 ? 'success' : 'neutral'"
                    icon
                    size="sm"
                    class="btn-link"
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
                    :type="$index > 2 ? 'danger' : 'neutral'"
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
    <modal-automotor
      v-show="isModalVisible"
      :riesgo_automotor="riesgo_automotor"
      :modo="modoEditar"
      @close="closeModal"
      @recargar="cargar"
    ></modal-automotor>
  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import { BaseAlert } from 'src/components';
import { BaseSwitch } from 'src/components/index';
import http from '../../../../API/http-request.js';
import { mixin } from '../../../../mixins/mixin.js';
import { EventBus } from '../../../../main.js';
import ModalAutomotor from './ModalAutomotor';

export default {
  mixins: [mixin],
  name: 'tabla-riesgo-automotor',
  components: {
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    [Select.name]: Select,
    [Option.name]: Option,
    BaseSwitch,
    BaseAlert,
    BasePagination,
    ModalAutomotor
  },
  props: {
    poliza: {
      type: Object
    }
  },
  data() {
    return {
      url: 'riesgo_automotor',
      riesgo_automotor: {}
    };
  },
  methods: {
    cargar() {
      http.loadOne(this.url, this.poliza.id).then(r => {
        console.log(r.data.data);
        this.tableData = r.data.data;
      });
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
      // this.organizador = {
      //   activo: true
      // };
    },
    showModal() {
      this.vaciarForm();
      // this.$validator.reset();
      // this.errors.clear();
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.vaciarForm();
      // this.$validator.reset();
      // this.errors.clear();
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
    }
  },
  mounted() {
    this.cargar();
  }
};
</script>
