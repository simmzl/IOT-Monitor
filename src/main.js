// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';

import info from './components/info/info';
import charts from './components/charts/charts';
import labvideo from './components/video/labvideo';
import equipment from './components/equipment/equipment';
import equipinput from './components/equipment/equipinput';
import equipsearch from './components/equipment/equipsearch';
import equiprepair from './components/equipment/equiprepair';
Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(VueRouter);

let routes = [
  { path: '/info', component: info },
  { path: '/charts', component: charts },
  { path: '/video', component: labvideo },
  {
    path: '/equipment',
    component: equipment,
    redirect: '/equipinput',
    children: [
      { path: '/equipinput', components: {equip :equipinput}},
      { path: '/equipsearch', components: {equip :equipsearch}},
      { path: '/equiprepair', components: {equip :equiprepair}}
  ]},
];

let router = new VueRouter({
  linkActiveClass: 'active',
  routes
});

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App },
  methods: {}
});
router.push('equipment');

Vue.prototype.isNumber = data => {
  return /^\d{1,10}$/.test(data);
};
Vue.prototype.isEmail = data => {
  return   /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test(data);
};
Date.prototype.addZero = function (num) {
  if (num < 10) {
    return num = "0" + num;
  } else {
    return num;
  }
};
Date.prototype.toLocaleString = function () {
  return this.getFullYear() + "/" + this.addZero((this.getMonth() + 1)) + "/" + this.addZero(this.getDate()) + "/ " + this.addZero(this.getHours()) + ":" + this.addZero(this.getMinutes());
};
