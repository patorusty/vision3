<template>
  <div class="content">
    <div class="row">
      <div class="col-12">
        <card card-body-classes="table-full-width">
          <div>
            <div class="col-12 row justify-content-center justify-content-sm-between flex-wrap">
              <base-input>
                <el-input
                  type="search"
                  class="mb-3 search-input"
                  clearable
                  prefix-icon="el-icon-search"
                  placeholder="Buscar"
                  aria-controls="datatables"
                ></el-input>
              </base-input>
              <router-link
                slot="header"
                to="/configuracion/usuarios/create"
              >
                <base-button
                  class="animation-on-hover pull-right"
                  type="primary"
                >Crear</base-button>
              </router-link>
            </div>
            <el-table :data="queriedData">
              <el-table-column
                label="Apellido"
                prop="apellido"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                label="Nombre"
                prop="nombre"
                :min-width="80"
              ></el-table-column>
              <el-table-column
                prop="email"
                label="Email"
                :min-width="100"
              ></el-table-column>
              <el-table-column label="Activo">
                <div slot-scope="{ row }">
                  <div v-if="row.activo == 1">SI</div>
                  <div v-else>NO</div>
                </div>
              </el-table-column>
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
                    <router-link :to="{ name: 'Editar Usuario', params: { id: props.row.id }}">
                      <base-button
                        class="edit btn-link"
                        type="warning"
                        size="sm"
                        icon
                      >
                        <i class="tim-icons icon-pencil"></i>
                      </base-button>
                    </router-link>

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
        </card>
      </div>
    </div>

  </div>
</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination, BaseAlert } from 'src/components';
import http from '../../../API/http-request.js';
import { mixin } from '../../../mixins/mixin.js';
import { EventBus } from '../../../main.js';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    BaseAlert,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn
  },
  data() {
    return {
      usuario: {},
      url: 'configuracion/usuarios'
    };
  },
  methods: {
    cargar() {
      http.load(this.url).then(r => (this.tableData = r.data.data));
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('configuracion/usuarios', id).then(() => {
            this.notifyVue('danger', 'El Usuario ha sido eliminado');
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
