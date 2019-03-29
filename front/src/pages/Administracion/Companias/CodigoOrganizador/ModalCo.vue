<template>
  <SlideYUpTransition :duration="500">
    <div v-show="isModalVisibleCodOrganizador" @close="closeModalCodigoOrg">
      <div class="modal-backdrop" @click="closeModalCodigoOrg">
        <div class="col-md-6" @click.stop>
          <card type="secodary">
            <form>
              <div
                class="modal-titulo d-flex 
            align-item=center "
              >
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
                    <label for="nombre" class=" control-label"
                      >Organizadores</label
                    >
                    <div class="">
                      <select
                        name="organizador_id"
                        class="form-control form-control-sm"
                        v-model="codigo_organizador.organizador_id"
                      >
                        <option
                          v-for="organizador in organizadores"
                          :key="organizador.id"
                          v-bind:value="organizador.id"
                        >
                          {{ organizador.apellido }}
                          {{ organizador.nombre }} (Matricula:{{
                            organizador.matricula
                          }})
                        </option>
                      </select>
                    </div>
                    <label for="cuit" class="control-label"
                      >Codigo Organizador</label
                    >
                    <div class="">
                      <input
                        type="text"
                        v-model="codigo_organizador.codigo_organizador"
                        class="form-control form-control-sm"
                        id="codigo_organizador"
                        name="codigo_organizador"
                        placeholder=""
                      />
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
                  >Crear</base-button
                >
                <base-button
                  v-show="modoEditar"
                  class="btn btn-primary ladda-button"
                  type="submit"
                  @click="updateCodigo_Organizador"
                  >Guardar</base-button
                >
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
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['organizador', 'companiaId', 'modo'],
  name: 'modal-co',
  mixins: [mixin],
  data() {
    return {
      url: 'administracion/organizadores',
      modelValidations: {
        codigo_organizador: {
          required: true
        }
      }
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch
  }
};
</script>
