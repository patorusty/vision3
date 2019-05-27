<template>
  <div class="col-md-12">
    <card class="mt-4 ">
      <div class="col-sm-12 row align-items-center" slot="header">
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
            <el-table-column min-width="200" label="marca">
              <div slot-scope="{ row }">
                {{ row.automotor_marca.nombre }}
                {{ row.automotor_version.nombre }}
              </div>
            </el-table-column>

            <el-table-column
              min-width="80"
              label="Patente"
              align="left"
              prop="patente"
            >
            </el-table-column>
            <el-table-column
              min-width="90"
              align="left"
              label="Suma Asegurada"
              prop="valor_total"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              align="left"
              label="Cobertura"
              prop="cobertura.nombre"
            >
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
                    @click.native="editar(props.row.id)"
                    type="warning"
                    icon
                    size="sm"
                    class="edit btn-link"
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                </el-tooltip>
              </div>
            </el-table-column>
          </el-table>
        </div>
      </div>
      <vue-picture-swipe :items="imagenes"></vue-picture-swipe>
    </card>

    <modal-automotor
      v-if="isModalVisible"
      :riesgo_automotor="riesgo_automotor"
      :modo="modoEditar"
      :poliza="poliza"
      :compania_id="poliza.compania_id"
      @close="closeModal"
      @recargar="cargar"
    ></modal-automotor>
    <modal-automotor-edit
      v-if="dataLoaded"
      v-show="isModalEditVisible"
      :riesgo_automotor="riesgo_automotor"
      :modo="modoEditar"
      :poliza="poliza"
      :compania_id="poliza.compania_id"
      @close="closeModal"
      @recargar="cargar"
    ></modal-automotor-edit>    
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
import ModalAutomotorEdit from './ModalAutomotorEdit';
import VuePictureSwipe from 'vue-picture-swipe';

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
    ModalAutomotor,
    ModalAutomotorEdit,
    VuePictureSwipe
  },
  props: {
    poliza: {
      type: Object
    }
  },
  data() {
    return {
      url: 'riesgo_automotores',
      riesgo_automotor: {},
      isModalEditVisible: false,
      dataLoaded: false,
      imagenes: [
        {
          path: 'http://localhost:8000/images/1558850310auto2.jpeg',
          thumbnail: 'http://localhost:8000/images/1558850310auto2.jpeg'
        },
        {
          path: 'http://localhost:8000/images/1558850310auto3.jpg',
          thumbnail: 'http://localhost:8000/images/1558850310auto3.jpg'
        }
      ]
    };
  },
  methods: {
    cargar() {
      http.loadOne(this.url, this.poliza.id).then(r => {
        this.tableData = r.data.data;
      });
      http.loadOne('/polizas/busquedaPolizaId', this.poliza.id).then(r => {
        if (r.data.data.length < 1) {
          this.isModalVisible = true;
        }
      });
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    },
    showModal() {
      this.vaciarForm();
      this.isModalEditVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
      this.isModalEditVisible = false;
      this.vaciarForm();
    },
    editar(id) {
      http
        .loadOne('/riesgo_automotor', id)
        .then(r => {
          this.riesgo_automotor = r.data.data;
          this.dataLoaded = true;
          this.$nextTick(() => {
            EventBus.$emit('MMV', this.riesgo_automotor);
          });
          this.showModal();
        })
        .catch(e => console.log(e));
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('polizas', id).then(() => {
            this.notifyVue('danger', 'El cliente ha sido eliminado');
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
