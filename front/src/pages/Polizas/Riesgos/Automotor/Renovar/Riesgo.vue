<template>
  <div class="modal-contenido">
    <div class="col-md-12">
      <div class="row pl-3">
        <div class="col-md-6 ">
          <div class="row ">
            <p class="text-primary">Asegurado:</p>
            &nbsp;&nbsp;
            <p>
              {{ poliza.clientes.apellido }}&nbsp;{{ poliza.clientes.nombre }}
            </p>
          </div>
          <div class="row ">
            <p class="text-primary">Compañia:</p>
            &nbsp;&nbsp;
            <p>{{ poliza.companias.nombre }}</p>
          </div>
          <div class="row ">
            <p class="text-primary">Marca:</p>
            &nbsp;&nbsp;
            <p>{{ riesgo_automotor.automotor_marca.nombre }}</p>
          </div>
          <div class="row ">
            <p class="text-primary">Modelo:</p>
            &nbsp;&nbsp;
            <p>{{ riesgo_automotor.automotor_version.nombre }}</p>
          </div>
          <div class="row ">
            <p class="text-primary">Año:</p>
            &nbsp;&nbsp;
            <p>{{ riesgo_automotor.automotor_anio.anio_id }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row ">
            <p class="text-primary">Renueva Poliza:</p>
            &nbsp;&nbsp;
            <p>{{ poliza.numero }}</p>
          </div>
          <div class="row ">
            <p class="text-primary">Productor:</p>
            &nbsp;&nbsp;
            <p></p>
            <p>{{ poliza.codigo_productor.productores.apellido }}</p>
            <p>{{ poliza.codigo_productor.productores.nombre }}</p>
            &nbsp;
            <p>- Cod. (</p>
            &nbsp;
            <p>{{ poliza.codigo_productor.codigo_productor }}</p>
            <p>)</p>
          </div>
          <div class="row ">
            <p class="text-primary">Patente:</p>
            &nbsp;&nbsp;
            <p>{{ riesgo_automotor.patente }}</p>
          </div>
          <div class="row ">
            <p class="text-primary">Motor:</p>
            &nbsp;&nbsp;
            <p>{{ riesgo_automotor.nro_motor }}</p>
          </div>
          <div class="row ">
            <p class="text-primary">Chasis:</p>
            &nbsp;&nbsp;
            <p>{{ riesgo_automotor.nro_chasis }}</p>
          </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-6">
          <label>Valor Vehiculo</label>
          <base-input
            v-model="riesgo_automotor_nuevo.valor_vehiculo"
            name="valor_vehiculo"
            v-validate="'required'"
            :error="getError('valor_vehiculo')"
          >
          </base-input>
          <label>Ajuste</label>
          <el-select
            filterable
            class="select-primary"
            v-model="riesgo_automotor.ajuste"
            name="ajuste"
          >
            <el-option
              v-for="ajuste in ajustes"
              :key="ajuste.value"
              :label="ajuste.label"
              :value="ajuste.value"
              class="select-primary"
            ></el-option>
          </el-select>
        </div>
        <div class="col-md-6">
          <label>Cobertura</label>
          <el-select
            filterable
            class="select-primary"
            :class="{ errorS: errorSelect.cobertura_id }"
            v-model="riesgo_automotor.cobertura_id"
            name="estado_general"
            @change="touchSelect('cobertura_id'), coberturaSeleccionada()"
          >
            <el-option
              v-for="cobertura in coberturas"
              :key="cobertura.id"
              :label="cobertura.nombre"
              :value="cobertura.id"
              class="select-primary"
            ></el-option>
          </el-select>
          <p class="errorSelect" v-show="errorSelect.cobertura_id">
            Este campo es obligatorio
          </p>
          <base-input
            class="mt-2"
            label="Franquicia"
            v-model="riesgo_automotor.poliza_id"
            name="franquicia"
            :disabled="cobertura.todo_riesgo == 0"
          >
          </base-input>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mixin } from '../../../../../mixins/mixin.js';
import { Select, Option } from 'element-ui';
import http from '../../../../../API/http-request.js';
import { TheMask } from 'vue-the-mask';
import { EventBus } from '../../../../../main.js';

export default {
  props: {
    riesgo_automotor: {
      type: Object,
      required: true,
      default: null
    },
    poliza: {
      type: Object,
      required: true,
      default: null
    }
  },
  mixins: [mixin],
  name: 'modal-renovar-automotor',
  components: {
    [Select.name]: Select,
    [Option.name]: Option,
    TheMask
  },
  data: () => ({
    // riesgo_automotor:{
    //   automotor_version: {
    //     nombre: ''
    //   },
    //   automotor_version: {
    //     nombre: ''
    //   }
    // },
    dataLoaded: false,
    riesgo_automotor_nuevo: {},
    marcas: {},
    marca: {},
    marca_id: '',
    automotor_marcas: {},
    automotor_modelos: {},
    coberturas: [],
    cobertura: {},
    modelos: [],
    modelo: {},
    anios: [],
    versiones: [],
    url: '/anios/filtrar',
    errorSelect: {
      automotor_anio_id: false,
      automotor_marca_id: false,
      automotor_modelo_id: false,
      automotor_version_id: false,
      cobertura_id: false,
      tipo_carroceria: false
    },
    selected: {
      automotor_anio_id: false,
      automotor_marca_id: false,
      automotor_modelo_id: false,
      automotor_version_id: false,
      cobertura_id: false,
      tipo_carroceria: false
    },
    tipo_patentes: [
      {
        value: 0,
        label: 'Nacional'
      },
      {
        value: 1,
        label: 'Mercosur'
      }
    ],
    ajustes: [
      {
        value: '0%',
        label: '0%'
      },
      {
        value: '10%',
        label: '10%'
      },
      {
        value: '20%',
        label: '20%'
      },
      {
        value: '30%',
        label: '30%'
      }
    ]
  }),
  methods: {
    cargarMarcas() {
      http.load('administracion/marcas', this.marca_id).then(r => {
        this.marcas = r.data.data;
      });
    },
    buscarMarca() {
      http.loadOne('administracion/marcas', this.marca_id).then(r => {
        this.marca = r.data.data;
      });
    },
    filtrarModeloPorMarca(id) {
      this.riesgo_automotor.automotor_modelo_id = '';
      this.versiones = [];
      http.loadOne('/modelos/filtrar', id).then(r => {
        this.modelos = r.data.data;
      });
    },
    filtrarVersionesDeModelo(url, anio, modelo) {
      this.riesgo_automotor.automotor_version_id = '';
      this.versiones = [];
      http.search2(url, anio, modelo).then(r => {
        this.versiones = r.data.data;
      });
    },
    cargarCoberturas() {
      http.loadOne('cobertura/compania', this.poliza.compania_id).then(r => {
        this.coberturas = r.data.data;
      });
    },
    cargarAnios() {
      http.load('anios', this.anio_id).then(r => {
        this.anios = r.data.data;
      });
    },
    touchSelect(val) {
      if (
        !this.riesgo_automotor[`${val}`] ||
        this.riesgo_automotor[`${val}`] === undefined
      ) {
        this.selected[val] = false;
        this.errorSelect[val] = true;
      } else {
        this.selected[val] = true;
        this.errorSelect[val] = false;
      }
    },
    checkSelect() {
      let valor = true;
      Object.entries(this.selected).forEach(select => {
        if (select[1] == false && !this.riesgo_automotor[`${select[0]}`]) {
          this.errorSelect[`${select[0]}`] = true;
          valor = false;
        } else {
          this.errorSelect[`${select[0]}`] = false;
          valor = true;
        }
      });
      return valor;
    },
    coberturaSeleccionada() {
      http
        .loadOne('/cobertura', this.riesgo_automotor.cobertura_id)
        .then(r => (this.cobertura = r.data.data));
    },
    reset() {
      this.riesgo_automotor.automotor_marca_id = '';
      this.riesgo_automotor.automotor_modelo_id = '';
      this.riesgo_automotor.automotor_version_id = '';
    }
  },
  created() {
    this.cargarMarcas();
    this.cargarCoberturas();
    this.cargarAnios();
  },
  mounted() {
    EventBus.$on('MMV', value => {
      http.loadOne('/modelos/filtrar', value.automotor_marca_id).then(r => {
        this.modelos = r.data.data;
      });
      http
        .search2(this.url, value.automotor_anio_id, value.automotor_modelo_id)
        .then(r => {
          this.versiones = r.data.data;
        });
    });
  }
};
</script>
