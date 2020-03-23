<template>

</template>

<script>
import IconBase from '../components/Icons/IconBase';
import IconCar from '../components/Icons/IconCar';
import IconMoon from '../components/Icons/IconMoon';
import http from '../API/http-request.js';
import StatsCard from 'src/components/Cards/StatsCard';
import { EventBus } from '../main.js';

export default {
  components: {
    IconBase,
    IconCar,
    IconMoon,
    StatsCard,
  },

}
  
</script>
<style>
h1 {
  color: black;
}
.iconos {
  color: red;
}
</style>
