<template>
<div>
  <h1>Home </h1>
  <p class="iconos">
  <icon-base  icon-name="car" width="32" height="32" vB="0 0 32 32" iconColor="blue"><icon-car /></icon-base>
  <icon-base  icon-name="moon" width="32" height="32"><icon-moon /></icon-base>

  </p>


</div>
</template>

<script>
import axios from 'axios';
import IconBase from '../components/Icons/IconBase';
import IconCar from '../components/Icons/IconCar';
import IconMoon from '../components/Icons/IconMoon';
export default {
  components: {
    IconBase,
    IconCar,
    IconMoon
  },
  methods: {
    prueba() {
      axios.get('http://127.0.0.1:8000/api/clientes').then(res => {
        console.log(res.data);
      });
    }
  },
  created() {
    this.prueba();
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
