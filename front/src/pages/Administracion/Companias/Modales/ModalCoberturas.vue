
  <template>
  <SlideYUpTransition :duration="500">
    <div
      v-show="isModalVisibleCobertura"
      @close="closeModalCobertura"
    >
      <div
        class="modal-backdrop"
        @click="closeModalCobertura"
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
                <h4>Cobertura</h4>
                <button
                  class="close "
                  type="button"
                  aria-label="Close"
                  @click="closeModalCobertura"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-contenido">
                <!-- ACA VA EL FORMULARIO -->
                <div class="row">
                  <div class="col-md-6">
                    <label
                      for="nombre"
                      class=" control-label"
                    >Nombre Cobertura</label>
                    <div class="">
                      <input
                        type="text"
                        v-model="cobertura.nombre"
                        class="form-control form-control-sm"
                        id="nombre"
                        name="nombre"
                      >
                    </div>
                    <label
                      for="antiguedad"
                      class=" control-label"
                    >Antiguedad (En Años)</label>
                    <div class="">
                      <input
                        type="number"
                        v-model="cobertura.antiguedad"
                        class="form-control form-control-sm"
                        id="antiguedad"
                        name="antiguedad"
                      >
                    </div>
                    <label
                      for="todo_riesgo"
                      class=" control-label"
                    >Todo Riesgo</label>
                    <div class="">
                      <input
                        type="checkbox"
                        v-model="cobertura.todo_riesgo"
                        class="checkbox-template"
                        id="todo_riesgo"
                        name="todo_riesgo"
                      >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label
                      for="franquicia"
                      class=" control-label"
                    >Franquicia</label>
                    <div class="">
                      <input
                        type="text"
                        v-model="cobertura.franquicia"
                        class="form-control form-control-sm"
                        id="franquicia"
                        name="franquicia"
                      >
                    </div>
                    <label
                      for="ajuste"
                      class=" control-label"
                    >Ajuste</label>
                    <div class="">
                      <select
                        name='ajuste'
                        v-model="cobertura.ajuste"
                        class="form-control form-control-sm"
                      >
                        <option> 0 % </option>
                        <option> 10 % </option>
                        <option> 20 % </option>
                        <option> 30 % </option>
                      </select>
                    </div>
                    <label
                      for="detalle"
                      class=" control-label"
                    >Detalle</label>
                    <div class="">
                      <input
                        type="textarea"
                        v-model="cobertura.detalle"
                        class="form-control form-control-sm"
                        id="detalle"
                        name="detalle"
                      >
                    </div>
                  </div>
                  <label>Cobertura Activa?</label>
                  <base-input>
                    <base-switch
                      v-model="cobertura.activo"
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
                  @click="crearCobertura"
                >Crear</base-button>
                <base-button
                  v-show="modoEditar"
                  class="btn btn-primary ladda-button"
                  type="submit"
                  @click="updateCobertura"
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
import axios from 'axios';
import { BaseProgress, BaseSwitch, TagsInput } from 'src/components/index';
export default {
  props: ['cobertura'],
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
    crear(event) {
      crear();
      this.$emit('crear', this.cobertura);
    },
    modificar() {
      this.$emit('modificar', this.cobertura);
    },
    // FUNCIONES COBERTURAS //
    cargarCobertura() {
      axios
        .get('http://127.0.0.1:8000/api/cobertura/' + this.compania.id)
        .then(response => {
          this.coberturas = response.data.data;
        })
        .catch(e => {
          console.log(e);
        });
    },
    crearCobertura() {
      this.cobertura.compania_id = this.compania.id;
      axios
        .post('http://127.0.0.1:8000/api/cobertura', this.cobertura)
        .then(response => {
          this.$notify({
            message: 'Cobertura Creada',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisibleCobertura = false;
          this.cargarCoberturas();
        })
        .catch(e => console.log(e));
    },
    updateCobertura(id) {
      axios
        .put('http://127.0.0.1:8000/api/cobertura/' + id, this.cobertura)
        .then(response => {
          this.$notify({
            message: 'Cobertura Modificada',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisibleCobertura = false;
          this.cargarCobertura();
        })
        .catch(e => console.log(e));
    }
    // editarCobertura(id) {
    //   (this.modoEditar = true), $('#modalcobertura').modal('show');
    //   axios
    //     .get('http://127.0.0.1:8000/api/cobertura/' + id)
    //     .then(function(response) {
    //       console.log(response.data.data);
    //       this.cobertura = response.data.data;
    //     })
    //     .catch(e => console.log(e));
    // },
    // borrarCobertura(id) {
    //   axios.delete('http://127.0.0.1:8000/api/cobertura/' + id).then(() => {
    //     this.cargarCobertura();
    //     console.log('borado!');
    //   });
    // }
    //FIN - FUNCIONES COBERTURAS //
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
            