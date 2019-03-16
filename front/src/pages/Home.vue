<template>
<div>
  <h1>Home </h1>
  <p class="iconos">
  <icon-base  icon-name="car" width="32" height="32" vB="0 0 32 32" iconColor="blue"><icon-car /></icon-base>
  <icon-base   icon-name="moon" width="32" height="32"><icon-moon /></icon-base>
  <button @click="prueba">Hola</button>

  </p>


</div>
</template>

<script>
import IconBase from '../components/Icons/IconBase';
import IconCar from '../components/Icons/IconCar';
import IconMoon from '../components/Icons/IconMoon';
import http from '../API/http-request.js';
export default {
  components: {
    IconBase,
    IconCar,
    IconMoon
  },
  data() {
    return {
      url: 'clientes',
      tableData: []
    };
  },
  methods: {
    prueba() {
      console.log(this.tabla);
    }
  },
  created() {
    http.load(this.url).then(res => (this.tableData = res.data.data));
  }
};
</script>
<style>
h1 {
  color: black;
}
.iconos {
  color: red;
}
</style>
