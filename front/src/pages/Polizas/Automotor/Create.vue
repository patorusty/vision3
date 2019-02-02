<template>
  <div>
    <form @submit.prevent="crearPoliza">
      <div class="page-header no-margin-bottom">
        <div class="container-fluid">
          <div class="row">
            <h4 class="text-primary pl-3">CREAR POLIZA </h4>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="block">
          <div class="block-body">
            <div class="row">
              <div class="col-md-12">
                <card class="stacked-form">
                  <form @submit.prevent>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-6">
                            <label
                              for="cliente"
                              class="control-label"
                            >Cliente</label>
                            <select
                              name='cliente_id'
                              class="form-control form-control-sm mb-1"
                              value="cliente_id"
                              v-model="poliza.cliente_id"
                            >
                              <option
                                class="form-control form-control-sm mb-1"
                                v-for="cliente in clientes"
                                :key="cliente.id"
                                v-bind:value="cliente.id"
                              >{{cliente.apellido}}
                                {{cliente.nombre}} //DNI:{{cliente.nro_dni}}</option>
                            </select>
                            <label
                              for="riesgo"
                              class=" control-label"
                            >Riesgo</label>
                            <select
                              name='tipo_riesgo_id'
                              class="form-control form-control-sm select2"
                              value="tipo_riesgo_id"
                              v-model="poliza.tipo_riesgo_id"
                            >
                              <option
                                v-for="tipo_riesgo in tipo_riesgos"
                                :key="tipo_riesgo.id"
                                v-bind:value="tipo_riesgo.id"
                              >{{tipo_riesgo.nombre}}</option>
                            </select>
                            <label
                              for="compania"
                              class=" control-label"
                            >Compañia</label>
                            <select
                              name='compania_id'
                              class="form-control form-control-sm select2"
                              value="compania_id"
                              id="compania_id"
                              v-model="poliza.compania_id"
                              @change='cargarCodigos_Productor(poliza.compania_id)'
                            >
                              <option
                                v-for="compania in companias"
                                :key="compania.id"
                                v-bind:value="compania.id"
                              >{{compania.nombre}}</option>
                            </select>

                          </div>
                          <div class="col-md-6">
                            <label
                              for="codigo_productor_id"
                              class=" control-label"
                            >Codigo Productor</label>
                            <select
                              name='codigo_productor_id'
                              class="form-control form-control-sm select2"
                              value="codigo_productor_id"
                              v-model="poliza.codigo_productor_id"
                            >
                              <option
                                v-for="codigo_productor in codigo_productores"
                                :key="codigo_productor.id"
                                v-bind:value="codigo_productor.id"
                              >{{codigo_productor.productores.apellido}}
                                {{codigo_productor.productores.nombre}}
                                ((Cod.{{codigo_productor.codigo_productor}}))</option>
                            </select>
                            <label
                              for="numero"
                              class=" control-label"
                            >Poliza N:</label>
                            <input
                              type="text"
                              class="form-control form-control-sm"
                              id="numero"
                              name="numero"
                              v-model="poliza.numero"
                              placeholder=""
                            >

                            <label
                              for="numero_solicitud"
                              class=""
                            >Nro de Solicitud:</label>
                            <p>{{poliza.numero_solicitud}}</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-4">
                            <label
                              for="tipo_vigencia_id"
                              class=" control-label"
                            >Vigencia</label>
                            <select
                              name='tipo_vigencia_id'
                              class="form-control form-control-sm "
                              value="tipo_vigencia_id"
                              v-model="poliza.tipo_vigencia_id"
                              @change='sumarMes(poliza.tipo_vigencia_id)'
                            >
                              <option
                                v-for="tipo_vigencia in tipo_vigencias"
                                :key="tipo_vigencia.id"
                                v-bind:value="tipo_vigencia.id"
                              >{{tipo_vigencia.vigencia}}</option>
                            </select>
                            <label
                              for="vigencia_desde"
                              class=" control-label"
                            >Desde:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="vigencia_desde"
                              name="vigencia_desde"
                              v-model="poliza.vigencia_desde"
                            >
                            <label
                              for="vigencia_hasta"
                              class=" control-label"
                            >Hasta:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="vigencia_hasta"
                              name="vigencia_hasta"
                              v-model="poliza.vigencia_hasta"
                            >
                          </div>

                          <div class="col-md-4">
                            <label
                              for="fecha_solicitud"
                              class=" control-label"
                            >Fecha de Solicitud:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="fecha_solicitud"
                              name="fecha_solicitud"
                              v-model="poliza.fecha_solicitud"
                            >
                            <label
                              for="fecha_emision"
                              class=" control-label"
                            >Emision:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="fecha_emision"
                              name="fecha_emision"
                              v-model="poliza.fecha_emision"
                            >
                            <label
                              for="fecha_recepcion"
                              class=" control-label"
                            >Recepcion:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="fecha_recepcion"
                              name="fecha_recepcion"
                              v-model="poliza.fecha_recepcion"
                            >

                          </div>

                          <div class="col-md-4">
                            <label
                              for="fecha_entrega_original"
                              class=" control-label"
                            >Entrega de Original:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="fecha_entrega_original"
                              name="fecha_entrega_original"
                              v-model="poliza.fecha_entrega_original"
                            >
                            <label
                              for="fecha_entrega_email"
                              class=" control-label"
                            >Envio x Email:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="fecha_entrega_email"
                              name="fecha_entrega_email"
                              v-model="poliza.fecha_entrega_email"
                            >
                            <label
                              for="fecha_entrega_correo"
                              class=" control-label"
                            >Envio x Correo:</label>
                            <input
                              type="date"
                              class="form-control form-control-sm"
                              id="fecha_entrega_correo"
                              name="fecha_entrega_correo"
                              v-model="poliza.fecha_entrega_correo"
                            >
                          </div>

                        </div>
                      </div>
                    </div>
                  </form>
                </card>
              </div>
            </div>
          </div>
        </div>
        <div class="row ">
          <div class="col-md-4">
            <div class="card p-3">
              <div class="row">
                <div class="col-md-6">
                  <label
                    for="premio"
                    class="control-label"
                  >Premio:</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="premio"
                    name="premio"
                    v-model="poliza.premio"
                  >
                </div>
                <div class="col-md-6">
                  <label
                    for="prima"
                    class="control-label"
                  >Prima:</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="prima"
                    name="prima"
                    v-model="poliza.prima"
                  >
                </div>
              </div>
              <div class="row">

                <div class="col-md-6">
                  <label
                    for="prima"
                    class="control-label"
                  >Comision:</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="comision"
                    value="0"
                    name="comision"
                    v-model="poliza.comision"
                  >
                </div>
                <div class="col-md-6">
                  <label
                    for="descuento"
                    class="control-label"
                  >Descuento:</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    id="descuento"
                    name="descuento"
                    v-model="poliza.descuento"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 ">
                <button
                  type="submit"
                  class="btn btn-primary"
                >Crear</button>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card p-3">
              <div class="row">
                <div class="col-6">
                  <label
                    for="medio_pago"
                    class=" control-label"
                  >Medio de Pago:</label>
                  <select
                    name='medio_pago'
                    class="form-control form-control-sm "
                    v-model="poliza.medio_pago"
                  >
                    <option value='TC'>TARJETA DE CREDITO</option>
                    <option value='DC'>DEBITO EN CUENTA</option>
                    <option value='EFT'>PAGO EFECTIVO / PAGO FACIL</option>
                  </select>
                  <div class="row">
                    <div class="col-md-8">
                      <label
                        for="plan_pago"
                        class=" control-label"
                      >Plan de Pago:</label>
                      <select
                        name='plan_pago'
                        class="form-control form-control-sm"
                        v-model="poliza.plan_pago"
                      >
                        <option value='MENSUAL'>MENSUAL</option>
                        <option value='TRIMESTRAL'>TRIMESTRAL</option>
                        <option value='SEMESTRAL'>SEMESTRAL</option>
                        <option value='TOTAL'>TOTAL</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label
                        for="cantidad_cuotas"
                        class=" control-label"
                      >Cant. Cuotas:</label>
                      <input
                        type="text"
                        class=" form-control form-control-sm"
                        id="cantidad_cuotas"
                        name="cantidad_cuotas"
                        v-model="poliza.cantidad_cuotas"
                      >
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label
                    for="detalle_medio_pago"
                    class="control-label"
                  >Detalle:</label>
                  <textarea
                    class="form-control form-control"
                    rows="3"
                    id="detalle_medio_pago"
                    name='detalle_medio_pago'
                    v-model="poliza.detalle_medio_pago"
                  ></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

</template>
<script>
export default {
  data() {
    return {
      poliza: {
        cliente_id: '',
        tipo_riesgo_id: '',
        compania_id: '',
        codigo_productor_id: '',
        numero: '',
        tipo_vigencia_id: '',
        vigencia_desde: new Date().toISOString().slice(0, 10),
        vigencia_hasta: '',
        numero_solicitud: '',
        estado_poliza_id: 1,
        fecha_solicitud: new Date().toISOString().slice(0, 10),
        fecha_emision: '',
        fecha_recepcion: '',
        fecha_entrega_original: '',
        fecha_entrega_email: '',
        fecha_entrega_correo: '',
        premio: '',
        prima: '',
        comision: '0',
        descuento: '0',
        medio_pago: '',
        plan_pago: '',
        cantidad_cuotas: '12',
        detalle_medio_pago: ''
      },
      //   cliente: {},
      clientes: {},
      companias: {},
      compania: {},
      tipo_riesgos: {},
      codigo_productores: {},
      tipo_vigencias: {},
      codigo_productor: {}
    };
  },
  methods: {
    sumarMes(mes) {
      let self = this;
      var mes;

      switch (this.poliza.tipo_vigencia_id) {
        case 6:
          var mes = 12;
          break;
        case 5:
          var mes = 6;
          break;
        case 4:
          var mes = 4;
          break;
        case 3:
          var mes = 3;
          break;
        case 2:
          var mes = 2;
          break;
        case 1:
          var mes = 1;
          break;
      }
      this.poliza.vigencia_hasta = addMonths(this.poliza.vigencia_desde, mes)
        .toISOString()
        .slice(0, 10);
    },

    cargarUltimoNumeroSolicitud() {
      let self = this;
      axios
        .get('http://127.0.0.1:8000/api/numerosolicitud')
        .then(function(response) {
          self.poliza.numero_solicitud =
            response.data.data[0].numero_solicitud + 1;
        });
    },
    crearPoliza() {
      let self = this;
      self.poliza.numero_solicitud = self.poliza.numero_solicitud;

      axios
        .post('http://127.0.0.1:8000/api/polizas', self.poliza)
        .then(() => {
          this.poliza = {};
          $router.push('http://127.0.0.1:8000/polizas');
        })
        .catch(e => console.log(e));
    },
    cargarClientes() {
      let self = this;
      axios.get('http://127.0.0.1:8000/api/clientes').then(function(response) {
        self.clientes = response.data.data;
      });
    },
    cargarTipo_Riesgos() {
      let self = this;
      axios
        .get('http://127.0.0.1:8000/api/tiporiesgo')
        .then(function(response) {
          self.tipo_riesgos = response.data.data;
        });
    },
    cargarTipo_Vigencias() {
      let self = this;
      axios
        .get('http://127.0.0.1:8000/api/tipovigencia')
        .then(function(response) {
          self.tipo_vigencias = response.data.data;
        });
    },
    cargarCompanias() {
      let self = this;
      axios
        .get('http://127.0.0.1:8000/api/administracion/companias')
        .then(function(response) {
          self.companias = response.data.data;
        });
    },
    cargarCodigos_Productor(id) {
      let self = this;
      axios
        .get('http://127.0.0.1:8000/api/codigoproductor/compania/' + id)
        .then(response => {
          self.codigo_productores = response.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    }
  },

  created() {
    this.cargarClientes();
    this.cargarTipo_Riesgos();
    this.cargarCompanias();
    this.cargarTipo_Vigencias();
    this.cargarUltimoNumeroSolicitud();
    this.sumarMes();
  }
};
</script>
