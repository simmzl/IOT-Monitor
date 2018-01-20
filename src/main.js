import Vue from 'vue'
import App from './App'
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';

import login from './components/login/login';

import info from './components/info/info';

// admin
import admin from './components/admin/admin'
import charts from './components/admin/charts/charts';
import labVideo from './components/admin/video/labvideo';
import equipment from './components/admin/equipment/equipment';
import equipInput from './components/admin/equipment/equipinput';
import equipSearch from './components/admin/equipment/equipsearch';
import equipMap from './components/admin/equipment/equipmap';
import equipRepair from './components/admin/equipment/equiprepair';
import file from './components/admin/file/file';
import userManage from './components/admin/userManage/userManage';

// serviceman
import serviceman from './components/serviceman/serviceman';
// import repair from './components/serviceman/equipment/repair';

// user
import user from './components/user/user';
import userFiles from './components/user/userFiles/userFiles'
import bookRepair from './components/user/bookRepair/bookRepair'

// import videojs from 'video.js';
// import VueVideoPlayer from 'vue-video-player';
// Vue.use(VueVideoPlayer);
// Vue.use(videojs);

Vue.config.productionTip = false;
// videojs.options.flash.swf = 'videojs-flash/node_modules/videojs-swf/dist/video-js.swf';

Vue.use(VueResource);
Vue.use(VueRouter);

let routes = [
  { path: '/', component: login },
  {
    path: '/admin',
    component: admin,
    redirect: '/admin/charts',
    children: [
      { path: 'info', component: info },
      { path: 'charts', component: charts },
      { path: 'video', component: labVideo },
      {
        path: 'equipment',
        component: equipment,
        redirect: '/admin/equipment/equipInput',
        children: [
          { path: 'equipInput', components: {equip :equipInput}},
          { path: 'equipSearch', components: {equip :equipSearch}},
          { path: 'equipMap', components: {equip :equipMap}},
          { path: 'equipRepair', components: {equip :equipRepair}}
        ]},
      { path: 'file', component: file },
      { path: 'userManage', component: userManage },
    ]
  },
  {
    path: '/user',
    component: user,
    redirect: '/user/charts',
    children: [
      { path: 'info', component: info },
      { path: 'userFiles', component: userFiles },
      // { path: 'bookRepair', component: bookRepair },
      { path: 'charts', component: charts },
      { path: 'video', component: labVideo }
    ]
  },
  {
    path: '/serviceman',
    component: serviceman,
    redirect: '/serviceman/repair',
    children: [
      { path: 'info', component: info },
      { path: 'bookRepair', component: bookRepair },
      { path: 'repair', component: equipRepair },
      // {
      //   path: 'equipment',
      //   component: equipment,
      //   redirect: '/serviceman/equipment/equipInput',
      //   children: [
      //     { path: 'equipInput', components: {equip :equipInput}},
      //     { path: 'equipSearch', components: {equip :equipSearch}},
      //     { path: 'equipMap', components: {equip :equipMap}},
      //     { path: 'equipRepair', components: {equip :equipRepair}}
      //   ]},
    ]
  }
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
router.push('/');
// router.push('/serviceman');
// router.push('/admin/equipment/equipInput');
// router.push('/admin/charts');

Vue.prototype.isNumber = data => {
  return /^[0-9]+.?[0-9]*$/.test(data);
};
Vue.prototype.isEmail = data => {
  return   /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/.test(data);
};
Vue.prototype.isDate = data => {
  let reg = new RegExp("^(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8]))))$|^((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[13579][26])00))-02-29)$");
  return reg.test(data);
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
