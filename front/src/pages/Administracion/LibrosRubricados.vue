<template>
  <div>
    <h1>Siniestros</h1>
    <p class="text-info">FECHA DE HOY</p>
    <p class="text-primary">{{ hoy }}</p>
    <p class="text-info">VIGENCIA DESDE</p>
    <p class="text-primary">{{ desde }}</p>
    <p class="text-info">VIGENCIA HASTA</p>
    <p class="text-primary">{{ hasta }}</p>
    <h1>ESTADO:</h1>
    <h1>{{ estado }}</h1>
  </div>
</template>

<script>
import {
  addMonths,
  startOfHour,
  setHours,
  setYear,
  setMonth,
  setDate,
  isWithinRange,
  subMonths,
  isAfter,
  isBefore,
  format
} from 'date-fns';
import http from '../../API/http-request';

export default {
  data() {
    return {
      hoy: format(new Date(), 'DD/MM/YYYY'),
      desde: setDate(setMonth(setYear(new Date(), 2018), 0), 1),

      hasta: format(
        setDate(setMonth(setYear(new Date(), 2019), 5), 1),
        'DD/MM/YYYY'
      ),
      estado: '',
      anulado: [],
      renovada: []
    };
  },
  methods: {
    estadoVigencia() {
      let hoy = new Date();
      let desde = setDate(setMonth(setYear(new Date(), 2020), 0), 1);
      //poliza.vigencia_desde;
      let hasta = setDate(setMonth(setYear(new Date(), 2020), 5), 1);
      //poliza.vigencia_hasta;

      if (this.anulado.length >= 1) {
        this.estado = 'ANULADO';
      } else {
        switch (true) {
          case true == isWithinRange(hoy, desde, subMonths(hasta, 1)) &&
            this.renovada.length < 1:
            this.estado = 'VIGENTE';
            break;
          case true == isWithinRange(hoy, subMonths(hasta, 1), hasta) &&
            this.renovada.length < 1:
            this.estado = 'VIGENTE / A RENOVAR';
            break;
          case true == isWithinRange(hoy, desde, hasta) &&
            this.renovada.length > 0:
            this.estado = 'VIGENTE / RENOVADA';
            break;
          case true == isAfter(hoy, hasta) && this.renovada.length > 0:
            // case true == isAfter(hoy, hasta) && existe una poliza que en su renueva_numero tenga su numero de poliza:
            this.estado = 'CUMPLIDA / RENOVADA';
            break;
          case true == isAfter(hoy, hasta):
            this.estado = 'CUMPLIDA';
            break;
          case true == isBefore(hoy, desde):
            this.estado = 'PENDIENTE';
            break;
        }
      }
    },

    chequeoRenovadas() {
      http
        .loadOne('poliza/predecesora', '909090')
        .then(r => {
          this.renovada = r.data.data;
        })
        .then(() => {
          this.estadoVigencia();
        });
    },

    checkAnuladas() {
      http
        .loadOne('endosos/poliza', 3)
        .then(r => {
          this.anulado = r.data.data;
        })
        .then(() => {
          this.chequeoRenovadas();
        });
    }
  },
  created() {
    // this.checkAnuladas();
    http.load('poliza/vigencias');
  }
};
</script>
