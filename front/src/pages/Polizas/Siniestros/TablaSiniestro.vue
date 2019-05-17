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
              label="Fecha"
            >
            </el-table-column>
            <el-table-column
              min-width="125"
              label="Numero"
              align="left"
            >
            </el-table-column>
            <el-table-column
              min-width="80"
              label="Cleas"
              align="left"
            >
            </el-table-column>
            <el-table-column
              min-width="100"
              align="left"
              label="Completo"
            >
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
    ModalSiniestros
  },
  data() {
    return {
      isModalVisibleSiniestro: false
    };
  },
  methods: {
    showModalSiniestro() {
      this.isModalVisibleSiniestro = true;
    },
    closeModalSiniestro() {
      this.isModalVisibleSiniestro = false;
    }
  }
};
</script>
