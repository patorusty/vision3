<template>
  <SlideYUpTransition :duration="500">
    <div class="modal-backdrop" @keydown.esc="close" @click="close">
      <div @click.stop style="width:25%;">
        <card>
          <form>
            <div class="d-flex justify-content-between mb-2">
              <h4>Version</h4>
              <button
                class="close"
                type="button"
                aria-label="Close"
                @click="close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-contenido">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <el-select
                      class="select-primary"
                      placeholder="Seleccionar Marca"
                      v-model="marca"
                      filterable
                      disabled
                    >
                      <el-option
                        v-for="marca in marcas"
                        :key="marca.id"
                        :value="marca.id"
                        :label="marca.nombre"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect">
                      Debe seleccionar una marca
                    </p>
                  </div>
                  <div class="mb-3">
                    <el-select
                      class="select-primary"
                      v-model="modeloSeleccionado"
                      name="modelo.marca_id"
                      @change="touchSelect"
                      filterable
                    >
                      <el-option
                        v-for="modelo in modelos"
                        :key="modelo.id"
                        :value="modelo.id"
                        :label="modelo.nombre"
                        class="select-primary"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect">
                      Debe seleccionar un modelo
                    </p>
                  </div>

                  <div class="mb-3">
                    <base-input
                      placeholder="Nombre de la Version"
                      v-model="version.nombre"
                      name="nombre"
                      v-validate="'required'"
                      :class="{ 'has-danger': versionUsed }"
                      :error="getErrorVersion('nombre', versionUsed)"
                      @keyup="buscarVersion"
                    ></base-input>
                  </div>

                  <!-- <div class="mb-3">
                    <el-select
                      multiple
                      class="select-info selectpicker"
                      v-model="version.automotor_anio_id"
                      :label="version.automotor_anio_id"
                      @change="touchSelect"
                      placeholder="Seleccionar Años"
                      filterable
                      collapse-tags
                      size="large"
                    >
                      <el-option
                        v-for="anio in anios"
                        :key="anio.id"
                        :value="anio.id"
                        :label="anio.anio"
                        class="select-info"
                      ></el-option>
                    </el-select>
                    <p class="errorSelect" v-show="errorSelect">
                      Debe seleccionar un modelo
                    </p>
                  </div> -->
                </div>
              </div>
            </div>
            <div class="modal-pie pull-right mt-3">
              <base-button
                v-if="modo == true"
                class="btn btn-primary ladda-button"
                type="submit"
                @click="actualizar"
                >Guardar</base-button
              >
              <base-button
                v-else
                class="btn btn-primary ladda-button"
                type="submit"
                @click="crear"
                >Crear</base-button
              >
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
import http from '../../../../API/http-request.js';
import { EventBus } from '../../../../main.js';
import debounce from '../../../../debounce.js';
import { mixin } from '../../../../mixins/mixin.js';

export default {
  props: ['version', 'marca', 'modeloSeleccionado', 'modo'],
  name: 'modal-versiones',
  mixins: [mixin],
  data() {
    return {
      url: 'administracion/versiones',
      nombreDeVersion: '',
      versionUsed: false,
      usedError: '',
      marcas: {},
      modelos: {},
      anios: {},
      errorSelect: false,
      selected: false
    };
  },
  components: {
    SlideYUpTransition,
    Card,
    BaseButton,
    [Option.name]: Option,
    [Select.name]: Select
  },
  methods: {
    close() {
      this.$emit('close');
      this.$validator.reset();
      this.errors.clear();
      this.versionUsed = false;
      this.usedError = '';
      this.selected = false;
      this.errorSelect = false;
      EventBus.$emit('resetInput', false);
    },
    crear() {
      if (!this.selected && this.$validator.validateAll().then(r => r)) {
        this.errorSelect = true;
      } else {
        this.$validator.validateAll().then(r => {
          if (r && !this.versionUsed) {
            this.$emit('crear', this.version);
            this.$validator.reset();
            this.errors.clear();
          }
        });
      }
    },
    actualizar() {
      this.$validator.validateAll().then(isValid => {
        if (isValid && !this.versionUsed) {
          http
            .update(this.url, this.version.id, this.version)
            .then(() => {
              this.close();
              this.$emit('recargar');
              this.notifyVue(
                'success',
                'El Modelo ha sido actualizado con exito'
              );
            })
            .catch(e => console.log(e));
        }
      });
    },
    buscarVersion: debounce(function() {
      if (this.version.nombre) {
        http
          .search('marcas/busquedaVersion?q=' + this.version.nombre)
          .then(r => {
            this.nombreDeVersion = r.data.data;
            if (this.nombreDeVersion.length > 0) {
              this.versionUsed = true;
            } else {
              this.versionUsed = false;
            }
          });
      }
    }, 500),
    getErrorVersion(fieldName, versionUsed) {
      if (!versionUsed) {
        return this.errors.first(fieldName);
      } else {
        return 'Esta version ya existe';
      }
    },
    cargarMarcas() {
      http.load('administracion/marcas', this.marca_id).then(r => {
        this.marcas = r.data.data;
      });
    },
    cargarAnios() {
      http.load('anios', this.anio_id).then(r => {
        this.anios = r.data.data;
        this.anios.reverse();
      });
    },
    filtrarModeloPorMarca(val) {
      console.log(val);
      http
        .loadOne('/modelos/filtrar', val)
        .then(r => (this.modelos = r.data.data));
    },
    // filtrarModelo() {
    //   http
    //     .loadOne('/versiones/filtrar', this.modelo_id)
    //     .then(r => (this.tableData = r.data.data));
    // },
    touchSelect() {
      this.selected = true;
      this.errorSelect = false;
    }
  },
  created() {
    this.cargarMarcas();
    this.cargarAnios();
  },
  mounted() {
    EventBus.$on('filtrarModeloPorMarca', val =>
      this.filtrarModeloPorMarca(val)
    );
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
