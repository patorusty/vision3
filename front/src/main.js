import Vue from 'vue';
import DashboardPlugin from './plugins/dashboard-plugin';
import App from './App.vue';
// router setup
import router from './routes/router';
import i18n from './i18n';
var diccionario = require('./validaciones.js').default;
import VeeValidate from 'vee-validate';
import { Validator } from 'vee-validate';
Vue.use(VeeValidate);
// console.log(diccionario);
Validator.localize('en', diccionario);
// plugin setup
Vue.use(DashboardPlugin);
/* eslint-disable no-new */
// Vue.config.devtools = false;
new Vue({
  el: '#app',
  render: h => h(App),
  router,
  i18n
});
