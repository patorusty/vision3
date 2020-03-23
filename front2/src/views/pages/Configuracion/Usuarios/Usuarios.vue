<template>
<v-container
  >  <v-card>
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
    :headers="headers" 
    :items="usuarios" 
    :search="search"
    ></v-data-table>
  </v-card>
</v-container>
</template>
<script>
import { http } from '../../../../http-request';

  export default {
    data () {
      return {
        dialog: false,
        usuarios:{},
        url: 'configuracion/usuarios',
        // search: '',
        headers: [
          { text: 'Apellido',value: 'apellido',},
          { text: 'Nombre', value: 'nombre' },
          { text: 'Mail', value: 'email' },
          { text: 'Tipo Usuario', value: 'tipo_usuario_id' },
          { text: 'Activo', value: 'activo' },
          // { text: 'Actions', value: 'iron' },
        ],
        editedIndex: -1,
      editedItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      defaultItem: {
        name: '',
        calories: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      }
    },
computed: {
    //   formTitle () {
    //     return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    //   },
    // },

    // watch: {
    //   dialog (val) {
    //     val || this.close()
    //   },
    },

    created () {
      this.cargar(),
      this.initialize()
    },

    methods: {
      cargar() {
      http.load(this.url).then(r => (this.tableData = r.data.data));
    },
      initialize () {
        this.tableData = [
          {
            nombre: this.usuario.nombre,
            apellido: this.r.apellido,
            email: this.r.email,
            tipo_usuario_id: this.r.tipo_usuario_id,
            activo: this.r.tipo_usuario_id,
          },
        ]
      },

      // editItem (item) {
      //   this.editedIndex = this.r.indexOf(item)
      //   this.editedItem = Object.assign({}, item)
      //   this.dialog = true
      // },

      // deleteItem (item) {
      //   const index = this.r.indexOf(item)
      //   confirm('Are you sure you want to delete this item?') && this.r.splice(index, 1)
      // },

      // close () {
      //   this.dialog = false
      //   setTimeout(() => {
      //     this.editedItem = Object.assign({}, this.defaultItem)
      //     this.editedIndex = -1
      //   }, 300)
      // },

      // save () {
      //   if (this.editedIndex > -1) {
      //     Object.assign(this.r[this.editedIndex], this.editedItem)
      //   } else {
      //     this.r.push(this.editedItem)
      //   }
      //   this.close()
      // },
    },

  }
</script>