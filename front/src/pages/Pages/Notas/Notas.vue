<template>
  <base-table :data="tableData" thead-classes="text-primary">
    <template slot-scope="{ row }">
      <td>
        <p class="title">{{ row.titulo }}</p>
        <p class="text-primary">{{ row.fecha }}</p>
        <p class="text-muted">{{ row.nota }}</p>
      </td>

      <td class="botones">
        <base-checkbox class="td-actions text-right" v-model="row.hecho"></base-checkbox>
        <el-tooltip content="Editar" effect="light" :open-delay="300" placement="top">
          <base-button
            @click.native="editar(row.id)"
            type="warning"
            icon
            size="sm"
            class="edit btn-link"
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
          <base-button type="danger" icon size="sm" class="btn-link">
            <i class="tim-icons icon-simple-remove"></i>
          </base-button>
        </el-tooltip>
      </td>
    </template>
  </base-table>
</template>
<script>
import { BaseTable } from '@/components';
import http from './../../../API/http-request.js';
import { mixin } from './../../../mixins/mixin.js';
import { EventBus } from './../../../main';
import { format } from 'date-fns';

export default {
  mixins: [mixin],
  name: 'notas',
  components: {
    BaseTable
  },

  data() {
    return {
      nota: {},
      url: 'notas'
    };
  },
  methods: {
    cargar() {
      http.load(this.url).then(r => {
        this.tableData = r.data.data;
        this.tableData.forEach(element => {
          console.log(element);
        });
      });
    },
    editar(url, id) {
      console.log(id);
      this.modoEditar = true;
      http
        .loadOne(this.url, id)
        .then(r => {
          this.nota = r.data.data;
          EventBus.$emit('showModalNotasEditar', this.nota);
        })
        .catch(e => console.log(e));
    },
    borrar(id) {
      http.delete(this.url, id).then(() => {
        this.notifyVue('danger', 'Nota eliminada');
        this.cargar();
      });
    }
  },
  created() {
    this.cargar();
  },
  mounted() {
    EventBus.$on('crearNota', () => this.crear());
    EventBus.$on('cargarNotas', () => this.cargar());
  }
};
</script>
<style>
.tachado {
  text-decoration: line-through;
}
.botones {
  width: 55px;
}
</style>