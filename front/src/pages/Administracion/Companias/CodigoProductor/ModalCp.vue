<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop style="width:25%;">
        <card type="secodary">
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Codigo Productor</h4>
              <button class="close" type="button" aria-label="Close" @click="close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-contenido">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <el-select
                      class="select-primary"
                      placeholder="Seleccionar Productor"
                      v-model="codigo_productor.productor_id"
                      v-validate="modelValidations.productor_id"
                      name="productor_id"
                      @change="touchSelect1"
                    >
                      <el-option
                        v-for="productor in productores"
                        :key="productor.id"
                        :value="productor.id"
                        :label="productor.apellido+' '+productor.nombre+' (Matricula: '+
                    productor.matricula+')'"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect1">Debe seleccionar un Productor</p>
                  </div>
                  <div class="mb-3">
                    <el-select
                      class="select-primary"
                      placeholder="Seleccionar Codigo Organizador"
                      v-model="codigo_productor.codigo_organizador_id"
                      v-validate="modelValidations.codigo_organizador_id"
                      name="organizador_id"
                      @change="touchSelect2"
                    >
                      <el-option
                        v-for="codigo_organizador in codigo_organizadores"
                        :key="codigo_organizador.id"
                        :value="codigo_organizador.id"
                        :label="codigo_organizador.organizadores.apellido+' '+codigo_organizador.organizadores.nombre+' (C.Org: '+
                    codigo_organizador.codigo_organizador+')'"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p
                      class="errorSelect"
                      v-show="errorSelect2"
                    >Debe seleccionar un Codigo Organizador</p>
                  </div>
                  <base-input
                    placeholder="Codigo Productor"
                    v-model="codigo_productor.codigo_productor"
                    name="codigo_productor"
                    v-validate="modelValidations.codigo_productor"
                    :class="{ 'has-danger': CPUsed }"
                    :error="getErrorCP('codigo_productor', CPUsed)"
                    @keyup="buscarCP"
                  ></base-input>
                  <p class="category">Activo?</p>
                  <base-switch
                    v-model="codigo_productor.activo"
                    type="primary"
                    on-text="ON"
                    off-text="OFF"
                  ></base-switch>
                </div>
              </div>
            </div>
            <div class="modal-pie pull-right mt-3">
              <base-button
                v-if="modo == true"
                class="btn btn-primary ladda-button"
                type="submit"
                @click="actualizar"
              >Guardar</base-button>
              <base-button
                v-else
                class="btn btn-primary ladda-button"
                type="submit"
                @click="crear"
              >Crear</base-button>
            </div>
          </form>
        </card>
      </div>
    </div>
  </SlideYUpTransition>
</template>

<script>
import { SlideYUpTransition } from 'vue2-transitions';
import { Select, Option } from 'element-ui';
import { Card } from 'src/components';
import { BaseButton } from 'src/components';
import { BaseSwitch } from 'src/components/index';
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import debounce from '../../../../debounce.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['codigo_productor', 'modo', 'compania'],
  name: 'modal-cp',
  mixins: [mixin],
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    BaseSwitch,
    [Option.name]: Option,
    [Select.name]: Select
  },
  data: () => ({
    url: 'administracion/productores',
    selected1: false,
    selected2: false,
    errorSelect1: false,
    errorSelect2: false,
    CPUsed: false,
    CP: '',
    usedError: '',
    productores: [],
    organizadores: [],
    codigo_organizadores: [],
    modelValidations: {
      codigo_productor: {
        required: true
      },
      productor_id: {
        required: true
      },
      codigo_organizador_id: {
        required: true
      }
    }
  }),
  methods: {
    close() {
      this.$emit('close');
      EventBus.$emit('resetInput', false);
      this.$validator.reset();
      this.errors.clear();
      this.CPUsed = false;
      this.usedError = '';
      this.selected1 = false;
      this.selected2 = false;
      this.errorSelect1 = false;
      this.errorSelect2 = false;
    },
    crear() {
      if (!this.selected1) {
        this.errorSelect1 = true;
      } else if (!this.selected2) {
        this.errorSelect2 = true;
      } else {
        this.$validator.validateAll().then(isValid => {
          if (
            isValid &&
            !this.CPUsed &&
            this.selected1 &&
            this.selected2 &&
            this.CP <= 0
          ) {
            this.$emit('crear', this.codigo_productor);
            this.$validator.reset();
            this.errors.clear();
            this.selected1 = false;
            this.selected2 = false;
          }
        });
      }
    },
    cargar() {
      http.loadOne('codigoorganizador/compania', this.compania.id).then(r => {
        this.codigo_organizadores = r.data.data;
      });
      http.load(this.url).then(r => (this.productores = r.data.data));
    },
    getErrorCP(fieldName, CPUsed) {
      if (!CPUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Este codigo productor ya esta en uso';
      }
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.CPUsed) {
          http
            .update(
              'codigoorganizador',
              this.codigo_productor.id,
              this.codigo_productor
            )
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'El productor ha sido actualizado con exito'
              );
            });
        }
      });
    },
    touchSelect1() {
      this.selected1 = true;
      this.errorSelect1 = false;
    },
    touchSelect2() {
      this.selected2 = true;
      this.errorSelect2 = false;
    },
    buscarCP: debounce(function() {
      if (this.codigo_productor.codigo_productor) {
        http
          .search(
            'codigo_productores/busquedaCP?q=' +
              this.codigo_productor.codigo_productor
          )
          .then(r => {
            this.CP = r.data.data;
            if (this.CP.length > 0) {
              this.CPUsed = true;
              this.usedError = 'Este codigo organizador ya esta en uso';
            } else {
              this.CPUsed = false;
            }
          });
      }
    }, 500)
  },
  created() {
    this.cargar();
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
}
.div-stop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  justify-content: center;
  align-items: center;
}
.el-select {
  display: block;
}
.errorSelect {
  color: #ec250d !important;
  font-size: 0.75rem;
  margin-bottom: 5px;
  margin-top: 5px;
}
</style>
