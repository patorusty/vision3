<template>
  <div>
    <div class="row ">
      <div class="col-md-10 mt-1">
        <base-input v-model="nota_siniestro_aut.nota"> </base-input>
      </div>
      <div id="botonenviar" class="col-md-2 pl-2 mt-0">
        <base-button type="primary submit" round icon @click="crear">
          <i class="tim-icons icon-send"></i>
        </base-button>
      </div>
    </div>
    <base-table :data="tableData" thead-classes="text-primary">
      <template slot-scope="{ row }">
        <td>
          <p class="text-danger">{{ row.user_id }} - {{ row.created_at }}</p>
          <p class="text-muted">{{ row.nota }}</p>
        </td>
        <td class="td-actions text-right">
          <el-tooltip
            @click.native="borrar(row.id)"
            content="Delete"
            effect="light"
            :open-delay="300"
            placement="top"
          >
            <base-button type="link">
              <i class="tim-icons icon-simple-remove"></i>
            </base-button>
          </el-tooltip>
        </td>
      </template>
    </base-table>
  </div>
</template>
<script>
import { BaseTable } from '@/components';
import http from '../../../API/http-request.js';
import { mixin } from '../../../mixins/mixin.js';
import { EventBus } from '../../../main.js';
import { format } from 'date-fns';

export default {
  components: {
    BaseTable
  },
  mixins: [mixin],

  props: {
    siniestro: {
      type: Object
    },
    dataLista: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      url: 'notasiniestroautomotor/siniestro_automotor_id',
      nota_siniestro_aut: {
        user_id: 1,
        nota: '',
        siniestro_automotor_id: ''
      }
    };
  },
  methods: {
    cargar(id) {
      let notas = [];
      http.loadOne(this.url, id).then(r => {
        notas = r.data.data;
        notas.forEach(nota => {
          nota.created_at = format(nota.created_at, 'DD/MM/YYYY');
        });
        this.tableData = notas;
      });
    },
    crear() {
      this.nota_siniestro_aut.siniestro_automotor_id = this.siniestro.id;
      http.create('/notas_siniestro_aut', this.nota_siniestro_aut).then(r => {
        this.cargar(this.siniestro.id);
        this.nota_siniestro_aut.nota = '';
        EventBus.$emit('resetInput', false);
      });
    },
    borrar(id) {
      this.dangerSwal().then(r => {
        if (r.value) {
          http.delete('/notas_siniestro_aut', id).then(() => {
            this.notifyVue('danger', 'El endoso ha sido eliminado');
            this.cargar(this.siniestro.id);
          });
        }
      });
    }
  },
  mounted() {
    EventBus.$on('cargarNotas', id => {
      console.log('pin');
      this.cargar(id);
    });
    EventBus.$on('closeModal', val => {
      this.nota_siniestro_aut.nota = val;
      EventBus.$emit('resetInput', false);
    });
  }
};
</script>
<style>
#botonenviar {
  margin-top: 1px;
}
</style>
