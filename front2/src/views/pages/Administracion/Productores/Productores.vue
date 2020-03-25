<template>
  <v-container>
    <v-card>
      <v-card-title>
        Productores
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <modal-usuarios
        >
        </modal-usuarios>
      </v-card-title>
      <v-data-table
        class="pa-2"
        :headers="headers"
        :items-per-page="5"
        :items="tableData"
        :search="search"
        multi-sort
      >
            <template v-slot:item.actions="{ item }" >
              <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
                color='success'
              >
                mdi-pencil
              </v-icon>
              <v-icon
              class='ml-2'
                small
                @click="deleteItem(item)"
                color='error'
              >
                mdi-close
              </v-icon>
            </template>
    </v-data-table>
    </v-card>
  </v-container>
</template>
<script>
import http from "../../../../http-request";
// import ModalUsuarios from "./ModalUsuarios";

export default {
  components:{
    // ModalUsuarios
  },
  data() {
    return {
      dialog: false,
      tableData: [],
      usuarios: {},
      url: "administracion/productores",
      search: "",
      headers: [
        { text: "Apellido", value: "apellido" },
        { text: "Nombre", value: "nombre" },
        { text: "cuit", value: "cuit" },
        { text: "Mail", value: "email" },
        { text: "celular", value: "telefono_2" },
        { text: "Activo", value: "activo" },
        { text: "Actions", value: "actions", sortable: false, align: 'right'
 },
      ]
    };
  },
  methods: {
    cargar() {
      http.load(this.url).then(r => (this.tableData = r.data.data));
    },
      
  },
  created() {
    this.cargar();
  },
};
</script>