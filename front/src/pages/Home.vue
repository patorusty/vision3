<template>
  <h1>Home</h1>
</template>

<script>
import axios from 'axios';
export default {
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
  background-color: red;
}
</style>


