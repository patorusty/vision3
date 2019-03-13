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
                >Crear</base-button>
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
              <el-table-column
                label="Activo"
                prop="activo"
              >
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
                  <base-button
                    @click.native="modoEdicion(props.$index, props.row)"
                    class="edit btn-link"
                    type="warning"
                    size="sm"
                    icon
                  >
                    <i class="tim-icons icon-pencil"></i>
                  </base-button>
                  <base-button
                    @click.native="borrarOrganizador(props.$index, props.row)"
                    class="remove btn-link"
                    type="danger"
                    size="sm"
                    icon
                  >
                    <i class="tim-icons icon-simple-remove"></i>
                  </base-button>
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

    <!-- INCION DEL MODAL //////////////////////// -->
    <!-- INCION DEL MODAL //////////////////////// -->
    <!-- INCION DEL MODAL //////////////////////// -->

    <SlideYUpTransition :duration="500">
      <div
        v-show="isModalVisible"
        @close="closeModal"
      >
        <div
          class="modal-backdrop"
          @click="closeModal"
        >
          <div
            class="col-md-6"
            @click.stop
          >
            <card type="secodary">
              <form>
                <div class="modal-titulo d-flex 
            align-item=center ">
                  <!-- ACA VA EL TITULO -->
                  <h4>Organizador</h4>
                  <button
                    class="close "
                    type="button"
                    aria-label="Close"
                    @click="closeModal"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-contenido">
                  <!-- ACA VA EL FORMULARIO -->
                  <div class="row">
                    <div class="col-md-6">
                      <label
                        for="nombre"
                        class=" control-label"
                      >Nombre</label>
                      <base-input
                        placeholder="Nombre"
                        v-model="organizador.nombre"
                        addon-left-icon="tim-icons icon-single-02"
                      >
                      </base-input>
                      <label
                        for="apellido"
                        class="control-label"
                      >Apellido</label>
                      <base-input
                        placeholder="Apellido"
                        v-model="organizador.apellido"
                        addon-left-icon="tim-icons icon-single-02"
                      >
                      </base-input>
                      <label
                        for="cuit"
                        class="control-label"
                      >Cuit</label>
                      <base-input
                        placeholder="Cuit"
                        v-model="organizador.cuit"
                      >
                      </base-input>
                      <label
                        for="matricula"
                        class="control-label"
                      >Matricula</label>
                      <base-input
                        placeholder="Matricula"
                        v-model="organizador.matricula"
                      >
                      </base-input>
                    </div>
                    <div class="col-md-6">
                      <label
                        for="email"
                        class="control-label"
                      >Email</label>
                      <base-input
                        placeholder="Email"
                        v-model="organizador.email"
                        addon-left-icon="tim-icons icon-email-85"
                      >
                      </base-input>
                      <label>Telefono</label>
                      <base-input
                        placeholder="Phone"
                        v-model="organizador.telefono_1"
                        addon-left-icon="tim-icons icon-mobile"
                      >
                      </base-input>
                      <label>Celular</label>
                      <base-input
                        placeholder="Phone"
                        v-model="organizador.telefono_2"
                        addon-left-icon="tim-icons icon-mobile"
                      >
                      </base-input>
                      <label>Organizador Activo?</label>
                      <base-input>
                        <base-switch
                          v-model="organizador.activo"
                          type="primary"
                          on-text="ON"
                          off-text="OFF"
                        ></base-switch>
                      </base-input>
                      &nbsp;
                    </div>
                  </div>
                </div>
                <div class="modal-pie pull-right mt-3">
                  <base-button
                    v-show="!modoEditar"
                    class="btn btn-primary ladda-button"
                    type="submit"
                    @click="crearOrganizador"
                  >Crear</base-button>
                  <base-button
                    v-show="modoEditar"
                    class="btn btn-primary ladda-button"
                    type="submit"
                    @click="updateOrganizador"
                  >Guardar</base-button>
                </div>
              </form>
            </card>
          </div>
        </div>
      </div>
    </SlideYUpTransition>
    <!-- FIN DEL MODAL /////////////////////////// -->
    <!-- FIN DEL MODAL /////////////////////////// -->
    <!-- FIN DEL MODAL /////////////////////////// -->

  </div>

</template>
<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination } from 'src/components';
import Fuse from 'fuse.js';
import axios from 'axios';
import { BaseAlert } from 'src/components';
import swal from 'sweetalert2';
import { SlideYUpTransition } from 'vue2-transitions';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import { BaseSwitch } from 'src/components/index';

export default {
  components: {
    BasePagination,
    SlideYUpTransition,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    BaseAlert,
    Card,
    BaseButton,
    BaseSwitch
  },
  computed: {
    /***
     * Returns a page from the searched data or the whole data. Search is performed in the watch section below
     */
    queriedData() {
      let result = this.tableData;
      if (this.searchedData.length > 0) {
        result = this.searchedData;
      }
      return result.slice(this.from, this.to);
    },
    to() {
      let highBound = this.from + this.pagination.perPage;
      if (this.total < highBound) {
        highBound = this.total;
      }
      return highBound;
    },
    from() {
      return this.pagination.perPage * (this.pagination.currentPage - 1);
    },
    total() {
      return this.searchedData.length > 0
        ? this.searchedData.length
        : this.tableData.length;
    }
  },
  data() {
    return {
      pagination: {
        perPage: 5,
        currentPage: 1,
        perPageOptions: [5, 10, 25, 50],
        total: 0
      },
      modoEditar: false,
      searchQuery: '',
      propsToSearch: [],
      tableData: [],
      searchedData: [],
      fuseSearch: null,
      isModalVisible: false,
      organizador: {}
    };
  },

  methods: {
    cargarOrganizadores() {
      axios
        .get('http://127.0.0.1:8000/api/administracion/organizadores/')
        .then(response => {
          this.dataLoaded = true;
          this.tableData = response.data.data;
        });
    },
    vaciarForm() {
      this.organizador = {
        activo: true
      };
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
    crearOrganizador() {
      axios
        .post(
          'http://127.0.0.1:8000/api/administracion/organizadores',
          this.organizador
        )
        .then(response => {
          this.$notify({
            message: 'Organizador Creado',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisible = false;
          this.cargarOrganizadores();
        })
        .catch(e => console.log(e));
    },
    modoEdicion(index, row) {
      this.showModal();
      this.modoEditar = true;
      axios
        .get('http://127.0.0.1:8000/api/administracion/organizadores/' + row.id)
        .then(response => {
          this.dataLoaded = true;
          this.organizador = response.data.data;
          console.log(this.organizador);
        })
        .catch(e => console.log(e));
    },
    updateOrganizador(id) {
      axios
        .put(
          'http://127.0.0.1:8000/api/administracion/organizadores/' + id,
          this.organizador
        )
        .then(response => {
          this.$notify({
            message: 'Organizador Modificado',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisible = false;
          this.cargarOrganizadores();
        })
        .catch(e => console.log(e));
    },
    borrarOrganizador(index, row) {
      swal({
        title: 'Estás seguro que queres borrar el registro?',
        text: `Esto no se puede revertir`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success btn-fill',
        cancelButtonClass: 'btn btn-danger btn-fill',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Sí, Eliminalo',
        buttonsStyling: false
      }).then(result => {
        if (result.value) {
          this.deleteRow(row);
          this.$notify({
            message: 'Organizador eliminado',
            timeout: 2000,
            icon: 'tim-icons icon-bell-55',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'danger'
          });
        }
      });
    },
    deleteRow(row) {
      axios
        .delete(
          'http://127.0.0.1:8000/api/administracion/organizadores/' + row.id
        )
        .then(() => {});
      let indexToDelete = this.tableData.findIndex(
        tableRow => tableRow.id === row.id
      );
      if (indexToDelete >= 0) {
        this.tableData.splice(indexToDelete, 1);
      }
    }
  },
  mounted() {
    this.fuseSearch = new Fuse(this.tableData, {
      keys: [],
      threshold: 0.3
    });

    this.cargarOrganizadores();
  },
  watch: {
    /**
     * Searches through the table data by a given query.
     * NOTE: If you have a lot of data, it's recommended to do the search on the Server Side and only display the results here.
     * @param value of the query
     */
    searchQuery(value) {
      let result = this.tableData;
      if (value !== '') {
        result = this.fuseSearch.search(this.searchQuery);
      }
      this.searchedData = result;
    }
  }
};
</script>
<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-titulo {
  justify-content: space-between;
}
</style>
