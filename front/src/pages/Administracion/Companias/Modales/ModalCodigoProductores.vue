<template>
  <SlideYUpTransition :duration="500">
    <div
      v-show="isModalVisibleCodProductor"
      @close="closeModalCodigoPro"
    >
      <div
        class="modal-backdrop"
        @click="closeModalCodigoPro"
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
                <h4>Codigo Productor</h4>
                <button
                  class="close "
                  type="button"
                  aria-label="Close"
                  @click="closeModalCodigoPro"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-contenido">
                <!-- ACA VA EL FORMULARIO -->
                <div class="row">
                  <div class="col-md-9">
                    <label
                      for="nombre"
                      class=" control-label"
                    >Productores</label>
                    <div class="">
                      <select
                        name='productor_id'
                        class="form-control form-control-sm"
                        v-model="codigo_productor.productor_id"
                      >
                        <option
                          v-for="productor in productores"
                          :key="productor.id"
                          v-bind:value="productor.id"
                        > {{productor.apellido}} {{productor.nombre}} (Matricula:{{productor.matricula}}) </option>
                      </select>
                    </div>
                    <label
                      for="nombre"
                      class=" control-label"
                    >Codigo Organizador</label>
                    <div class="">
                      <select
                        name='codigo_organizador_id'
                        class="form-control form-control-sm"
                        v-model="codigo_productor.codigo_organizador_id"
                      >
                        <option
                          v-for="codigo_organizador in codigo_organizadores"
                          :key="codigo_organizador.id"
                          v-bind:value="codigo_organizador.id"
                        > {{codigo_organizador.organizadores.apellido}} {{codigo_organizador.organizadores.nombre}} (Codigo Org: {{codigo_organizador.codigo_organizador}}) </option>
                      </select>
                    </div>
                    <label
                      for="cuit"
                      class="control-label"
                    >Codigo Productor</label>
                    <div class="">
                      <input
                        type="text"
                        v-model="codigo_productor.codigo_productor"
                        class="form-control form-control-sm"
                        id="codigo_productor"
                        name="codigo_productor"
                        placeholder=""
                      >
                    </div>
                    <label>Codigo Productor Activo?</label>
                    <base-input>
                      <base-switch
                        v-model="codigo_productor.activo"
                        type="primary"
                        on-text="ON"
                        off-text="OFF"
                      ></base-switch>
                    </base-input>
                  </div>
                </div>
                <div class="modal-pie pull-right mt-3">
                  <base-button
                    v-show="!modoEditar"
                    class="btn btn-primary ladda-button"
                    type="submit"
                    @click="crearCodigo_Productor"
                  >Crear</base-button>
                  <base-button
                    v-show="modoEditar"
                    class="btn btn-primary ladda-button"
                    type="submit"
                    @click="updateCodigo_Productor"
                  >Guardar</base-button>
                </div>
            </form>
          </card>
        </div>
      </div>
    </div>
  </SlideYUpTransition>
</template>
<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import { BaseSwitch } from 'src/components/index';
export default {
  props: ['codigoproductor'],
  data() {
    return {
      modoEdicion: false
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch
  },
  methods: {
    close() {
      this.$emit('close');
    },
    crear() {
      this.$emit('crear', this.codigoproductor);
    },
    modificar() {
      this.$emit('modificar', this.codigoproductor);
    },
    // FUNCIONES CODIGO PRODUCTOR //
    cargarCodigo_Productor() {
      axios
        .get(
          'http://127.0.0.1:8000/api/codigoproductor/compania/' +
            this.compania.id
        )
        .then(response => {
          this.codigo_productores = response.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    crearCodigo_Productor() {
      this.codigo_productor.compania_id = this.compania.id;
      axios
        .post(
          'http://127.0.0.1:8000/api/codigoproductor',
          this.codigo_productor
        )
        .then(response => {
          this.$notify({
            message: 'Codigo Productor Creado',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisibleCodProductor = false;
          this.cargarCodigo_Productor();
        })
        .catch(e => console.log(e));
    },
    updateCodigo_Productor(id) {
      axios
        .put(
          'http://127.0.0.1:8000/api/codigoproductor/' + id,
          this.codigo_productor
        )
        .then(response => {
          this.$notify({
            message: 'Codigo Productor Modificado',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisibleCodProductor = false;
          this.cargarCodigo_Productor();
        })
        .catch(e => console.log(e));
    }
    // editarCodigo_Productor(id) {
    //   (this.modoEditar = true), $('#modalcodigoproductor').modal('show');
    //   axios
    //     .get('http://127.0.0.1:8000/api/codigoproductor/' + id)
    //     .then(function(response) {
    //       this.codigo_productor = response.data.data;
    //     })
    //     .catch(e => console.log(e));
    // },
    // borrarCodigo_Productor(id) {
    //   axios
    //     .delete('http://127.0.0.1:8000/api/codigoproductor/' + id)
    //     .then(() => {
    //       this.cargarCodigo_Productor();
    //       console.log('borado!');
    //     });
    // }
    // FIN - FUNCIONES CODIGO PRODUCTOR
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