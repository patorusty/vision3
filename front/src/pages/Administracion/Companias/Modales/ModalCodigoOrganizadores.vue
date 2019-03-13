 <template>
  <SlideYUpTransition :duration="500">
    <div
      v-show="isModalVisibleCodOrganizador"
      @close="closeModalCodigoOrg"
    >
      <div
        class="modal-backdrop"
        @click="closeModalCodigoOrg"
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
                <h4>Codigo Organizador</h4>
                <button
                  class="close "
                  type="button"
                  aria-label="Close"
                  @click="closeModalCodigoOrg"
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
                    >Organizadores</label>
                    <div class="">
                      <select
                        name='organizador_id'
                        class="form-control form-control-sm"
                        v-model="codigo_organizador.organizador_id"
                      >
                        <option
                          v-for="organizador in organizadores"
                          :key="organizador.id"
                          v-bind:value="organizador.id"
                        > {{organizador.apellido}} {{organizador.nombre}} (Matricula:{{organizador.matricula}}) </option>
                      </select>
                    </div>
                    <label
                      for="cuit"
                      class="control-label"
                    >Codigo Organizador</label>
                    <div class="">
                      <input
                        type="text"
                        v-model="codigo_organizador.codigo_organizador"
                        class="form-control form-control-sm"
                        id="codigo_organizador"
                        name="codigo_organizador"
                        placeholder=""
                      >
                    </div>
                    <label>Codigo Organizador Activo?</label>
                    <base-input>
                      <base-switch
                        v-model="codigo_organizador.activo"
                        type="primary"
                        on-text="ON"
                        off-text="OFF"
                      ></base-switch>
                    </base-input>

                  </div>
                </div>
              </div>
              <div class="modal-pie pull-right mt-3">
                <base-button
                  v-show="!modoEditar"
                  class="btn btn-primary ladda-button"
                  type="submit"
                  @click="crearCodigo_Organizador"
                >Crear</base-button>
                <base-button
                  v-show="modoEditar"
                  class="btn btn-primary ladda-button"
                  type="submit"
                  @click="updateCodigo_Organizador"
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
  props: ['codigoorganizador'],
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
      this.$emit('crear', this.codigoorganizador);
    },
    modificar() {
      this.$emit('modificar', this.codigoorganizador);
    },
    // FUNCIONES CODIGO ORGANIZADOR //
    cargarCodigo_Organizador() {
      axios
        .get(
          'http://127.0.0.1:8000/api/codigoorganizador/compania/' +
            this.compania.id
        )
        .then(response => {
          this.codigo_organizadores = response.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    crearCodigo_Organizador() {
      this.codigo_organizador.compania_id = this.compania.id;
      axios
        .post(
          'http://127.0.0.1:8000/api/codigoorganizador',
          this.codigo_organizador
        )
        .then(response => {
          this.$notify({
            message: 'Codigo Organizador Creado',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisibleCodOrganizador = false;
          this.cargarCodigo_Organizador();
        })
        .catch(e => console.log(e));
    },
    updateCodigo_Organizador(id) {
      axios
        .put(
          'http://127.0.0.1:8000/api/codigoorganizador/' + id,
          this.codigo_organizador
        )
        .then(response => {
          this.$notify({
            message: 'Codigo Organizador Modificado',
            timeout: 3000,
            icon: 'tim-icons icon-alert-circle-exc',
            horizontalAlign: 'right',
            verticalAlign: 'top',
            type: 'success'
          });
          this.isModalVisibleCodOrganizador = false;
          this.cargarCodigo_Organizador();
        })
        .catch(e => console.log(e));
    }
    // editarCodigo_Organizador(id) {
    //   (this.modoEditar = true), $('#modalcodigoorganizador').modal('show');
    //   let self = this;
    //   axios
    //     .get('http://127.0.0.1:8000/api/codigoorganizador/' + id)
    //     .then(function(response) {
    //       self.codigo_organizador = response.data.data;
    //     })
    //     .catch(e => console.log(e));
    // },
    // borrarCodigo_Organizador(id) {
    //   axios
    //     .delete('http://127.0.0.1:8000/api/codigoorganizador/' + id)
    //     .then(() => {
    //       this.cargarCodigo_Organizador();
    //       console.log('borado!');
    //     });
    // }
    // FIN - FUNCIONES CODIGO ORGANIZADOR //
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