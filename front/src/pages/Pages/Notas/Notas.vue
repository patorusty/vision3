<template>
  <base-table
    :data="tableData"
    thead-classes="text-primary"
  >
    <template slot-scope="{ row }">
      <td>
        <p class="title">{{ row.titulo }}</p>
        <p class="text-primary">{{ row.fecha }}</p>
        <p class="text-muted">{{ row.nota }}</p>
      </td>
      <td class="botones">
        <base-checkbox
          class="td-actions text-right"
          v-model="row.hecho"
        ></base-checkbox>
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
            class="edit btn-link "
          >
            <i class="tim-icons icon-pencil"></i>
          </base-button>
        </el-tooltip>
        <el-tooltip
          @click.native="borrar(row.id)"
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
      </td>
    </template>
    <notas
      v-show="isModalVisibleNotas"
      :nota="nota"
      :modo="modoEditar"
      @close="closeModalNotas"
      @crear="crear"
      @recargar="cargar"
    />
  </base-table>
</template>
<script>
import { BaseTable } from '@/components';
import http from './../../../API/http-request.js';
import { mixin } from './../../../mixins/mixin.js';
import { EventBus } from './../../../main';
import { format } from 'date-fns';
import Notas from './ModalNotas';

export default {
  mixins: [mixin],
  components: {
    Notas,
    BaseTable
  },

  data() {
    return {
      nota: {},
      isModalVisibleNotas: false,
      url: 'notas'
    };
  },
  methods: {
    cargar() {
      http.load(this.url).then(r => (this.tableData = r.data.data));
    },
    crear() {
      this.showModalNotas();
      http.create(this.url, value).then(() => {
        this.notifyVue('success', 'Nota Creada');
        this.cargar();
        this.closeModal();
      });
    },
    editar(url, id) {
      this.showModalNotas();
      this.modoEditar = true;
      http
        .loadOne(this.url, id)
        .then(r => {
          this.nota = r.data.data;
        })
        .catch(e => console.log(e));
    },
    borrar(id) {
      http.delete(this.url, id).then(() => {
        this.notifyVue('danger', 'Nota eliminada');
        this.cargar();
      });
    },
    closeModalNotas() {
      this.vaciarForm();
      this.isModalVisibleNotas = false;
    },
    showModalNotas() {
      console.log('hola');
      this.isModalVisibleNotas = true;
      this.vaciarForm();
    },
    vaciarForm() {
      EventBus.$emit('resetInput', false);
    }
  },
  created() {
    this.cargar();
  },
  mounted() {
    EventBus.$on('showModalNotas', () => this.showModalNotas());
  }
};
</script>
<style>
.botones {
  width: 55px;
}
</style>