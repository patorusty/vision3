<template>
  <card>
    <template slot="header">
      <h3 class="card-title">Edicion Marca Modelo Version de Autos</h3>
    </template>

    <tabs type="primary">
      <tab-pane label="Marca">
        <tabla-marcas />
      </tab-pane>

      <tab-pane label="Modelos">
        <tabla-modelos />
      </tab-pane>

      <tab-pane label="Versiones">
        <tabla-versiones />
      </tab-pane>
    </tabs>
  </card>
</template>

<script>
import { Table, TableColumn, Select, Option } from 'element-ui';
import { BasePagination, TabPane, Tabs } from 'src/components';
import { BaseAlert } from 'src/components';
import http from '../../../API/http-request.js';
import { mixin } from '../../../mixins/mixin.js';
import { EventBus } from '../../../main.js';
import TablaMarcas from './Marcas/TablaMarcas';
import TablaModelos from './Modelos/TablaModelos';
import TablaVersiones from './Versiones/TablaVersiones';

export default {
  mixins: [mixin],
  components: {
    BasePagination,
    [Select.name]: Select,
    [Option.name]: Option,
    [Table.name]: Table,
    [TableColumn.name]: TableColumn,
    BaseAlert,
    TabPane,
    Tabs,
    TablaMarcas,
    TablaModelos,
    TablaVersiones
  },
  data() {
    return {
      dataLoaded: false
    };
  }
};
</script>
