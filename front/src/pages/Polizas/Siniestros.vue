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
    <h1> {{ estado }} </h1>

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
  isBefore
} from 'date-fns';

export default {
  data() {
    return {
      hoy: new Date(),
      desde: setDate(setMonth(setYear(new Date(), 2018), 0), 1),
      hasta: setDate(setMonth(setYear(new Date(), 2018), 5), 1),
      estado: ''
    };
  },
  methods: {
    estadoVigencia() {
      let hoy = new Date();
      let desde = setDate(setMonth(setYear(new Date(), 2020), 0), 1);
      let hasta = setDate(setMonth(setYear(new Date(), 2021), 5), 1);

      switch (true) {
        // case true == si existe una endoso de anulacion que tenga poliza_id:
        //   this.estado = 'ANULADO';
        //   break;
        case true == isWithinRange(hoy, desde, subMonths(hasta, 1)):
          this.estado = 'VIGENTE';
          break;
        case true == isWithinRange(hoy, subMonths(hasta, 1), hasta):
          this.estado = 'VIGENTE / A RENOVAR';
          break;
        // case true == isWithinRange(hoy, desde, subMonths(hasta, 1)) && existe una poliza que en su renueva_numero tenga su numero de poliza:
        //   this.estado = 'VIGENTE / RENOVADA';
        //   break;
        case true == isAfter(hoy, hasta):
          this.estado = 'CUMPLIDA';
          break;
        // case true == isAfter(hoy, hasta) && existe una poliza que en su renueva_numero tenga su numero de poliza:
        //   this.estado = 'CUMPLIDA / RENOVADA';
        //   break;
        case true == isBefore(hoy, desde):
          this.estado = 'PENDIENTE';
          break;
      }
    }
  },
  created() {
    this.estadoVigencia();
  }
};
</script>
