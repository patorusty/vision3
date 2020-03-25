<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on }">
        <v-btn color="primary" dark v-on="on">Crear</v-btn>
      </template>
      <v-card>
                    <form @submit.prevent="crear">

        <v-card-title>
          <span class="headline">Crear Usuario</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="6">
                <v-text-field label="Company" v-model="usuario.compania" :disabled="true"></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field label="E-Mail" v-model="usuario.email" hint="example of helper text only on focus" required></v-text-field>
              </v-col>
              
              <v-col cols="6">
                <v-text-field label="Nombre" v-model="usuario.nombre" required></v-text-field>
              </v-col>
              <v-col cols="6">
                <v-text-field label="Apellido" v-model="usuario.apellido" required></v-text-field>
              </v-col>
                <v-col cols="12" sm="4">
                <v-select
                  :items="tipo_usuarios"
                  label="Tipo de Usuario"
                  item-text="nombre"
                  item-value="id"
                  required
                  v-model="usuario.tipo_usuario_id"
                >
                </v-select>
              </v-col>
              <v-col cols="12" sm="4">
                    <v-switch class="ma-2" v-model="usuario.activo" label="Usuario Activo?"></v-switch>
              </v-col>
              <v-col cols="12" sm="4">
                    <v-avatar color="red">
                        <span class="white--text headline">nombre</span>
                    </v-avatar>              
              </v-col>  
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" text @click="dialog = false">Cerrar</v-btn>
          <v-btn color="green" text native-type="submit">Crear</v-btn>
        </v-card-actions>
        </form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import http from "../../../http-request";

  export default {

    data: () => ({
      url:"tipousuario",
      dialog: false,
      usuario: {
          compania: ' Vision',
          activo: true
      },
      tipo_usuarios: [],
      tipo_usuario: ''
    }),
    methods: {
        cargarTipo_Usuarios() {
        http.load(this.url).then(r => {
            this.tipo_usuarios = r.data.data;
        });
        console.log('hola')
    },
    crear() {
        console.log('llega?')
      http
        .create("configuracion/usuarios", this.usuario)
        .then(() => {
          this.notifyVue('success', 'El usuario ha sido creado con exito');
        //   this.cargar();
        })
        .catch(e => console.log(e));
    },
  
    

    },
    created() {
        this.cargarTipo_Usuarios();
    },
  }
</script>