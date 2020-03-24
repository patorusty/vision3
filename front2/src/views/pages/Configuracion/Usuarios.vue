<template>
  <v-container>
    <v-card>
      <v-card-title>
        Usuarios
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        class="pa-2"
        :headers="headers"
        :items-per-page="5"
        :items="tableData"
        :search="search"
      ></v-data-table>
    </v-card>
  </v-container>
</template>
<script>
import http from "../../../http-request";

export default {
  data() {
    return {
      dialog: false,
      tableData: [],
      usuarios: {},
      url: "configuracion/usuarios",
      search: "",
      headers: [
        { text: "Apellido", value: "apellido" },
        { text: "Nombre", value: "nombre" },
        { text: "Mail", value: "email" },
        { text: "Tipo Usuario", value: "tipo_usuario_id" },
        { text: "Activo", value: "activo" }
        // { text: 'Actions', value: 'iron' },
      ]
    };
  },
  methods: {
    cargar() {
      console.log("hola?");
      http.load(this.url).then(r => (this.tableData = r.data.data));
      console.log("loaded?");
    }
  },
  created() {
    this.cargar();
  }
};
</script>