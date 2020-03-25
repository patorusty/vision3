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
import http from "../../../http-request";
import ModalUsuarios from "./ModalUsuarios";



export default {
  components:{
    ModalUsuarios
  },
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









//modal?
  //     editItem (item) {
  //       this.editedIndex = this.tableData.indexOf(item)
  //       this.editedItem = Object.assign({}, item)
  //       this.dialog = true
  //     },

  //     deleteItem (item) {
  //       const index = this.tableData.indexOf(item)
  //       confirm('Are you sure you want to delete this item?') && this.tableData.splice(index, 1)
  //     },

  //     close () {
  //       this.dialog = false
  //       setTimeout(() => {
  //         this.editedItem = Object.assign({}, this.defaultItem)
  //         this.editedIndex = -1
  //       }, 300)
  //     },

  //     save () {
  //       if (this.editedIndex > -1) {
  //         Object.assign(this.tableData[this.editedIndex], this.editedItem)
  //       } else {
  //         this.tableData.push(this.editedItem)
  //       }
  //       this.close()
  //     },

  // computed: {
  //     formTitle () {
  //       return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
  //     },
  //   },

  //   watch: {
  //     dialog (val) {
  //       val || this.close()
  //     },
  //   },

    // -modal cierre
};
</script>