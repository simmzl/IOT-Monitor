import Vue from 'vue'
import App from './App'
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';

import login from './components/login/login';
const Info = () => import ('./components/info/info');

// admin
const Admin = () => import ('./components/admin/admin');

// import charts from './components/admin/charts/charts';
const Charts = () => import ('./components/admin/charts/charts');

const LabVideo = () => import ('./components/admin/video/labvideo');

const Equipment = () => import ('./components/admin/equipment/equipment');
const EquipInput = () => import ('./components/admin/equipment/equipinput');
const EquipSearch = () => import ('./components/admin/equipment/equipsearch');
const EquipMap = () => import ('./components/admin/equipment/equipmap');
const EquipRepair = () => import ('./components/admin/equipment/equiprepair');

const File = () => import ('./components/admin/file/file');
const UserManage = () => import ('./components/admin/userManage/userManage');

// serviceman
const Serviceman = () => import ('./components/serviceman/serviceman');

// user
const User = () => import ('./components/user/user');
const UserFiles = () => import ('./components/user/userFiles/userFiles');
const BookRepair = () => import ('./components/user/bookRepair/bookRepair');

import { getCookie } from './common/js/cookie.js'

Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(VueRouter);

let routes = [
  { path: '/', component: login },
  {
    path: '/admin',
    component: Admin,
    redirect: '/admin/charts',
    children: [
      { path: 'info', component: Info },
      { path: 'charts', component: Charts },
      { path: 'video', component: LabVideo },
      {
        path: 'equipment',
        component: Equipment,
        redirect: '/admin/equipment/equipInput',
        children: [
          { path: 'equipInput', components: {equip :EquipInput}},
          { path: 'equipSearch', components: {equip :EquipSearch}},
          { path: 'equipMap', components: {equip :EquipMap}},
          { path: 'equipRepair', components: {equip :EquipRepair}}
        ]},
      { path: 'file', component: File },
      { path: 'userManage', component: UserManage },
    ]
  },
  {
    path: '/user',
    component: User,
    redirect: '/user/charts',
    children: [
      { path: 'info', component: Info },
      { path: 'userFiles', component: UserFiles },
      // { path: 'bookRepair', component: bookRepair },
      { path: 'charts', component: Charts },
      { path: 'video', component: LabVideo }
    ]
  },
  {
    path: '/serviceman',
    component: Serviceman,
    redirect: '/serviceman/repair',
    children: [
      { path: 'info', component: Info },
      { path: 'bookRepair', component: BookRepair },
      { path: 'repair', component: EquipRepair },
      // {
      //   path: 'equipment',
      //   component: equipment,
      //   redirect: '/serviceman/equipment/equipInput',
      //   children: [
      //     { path: 'equipInput', components: {equip :equipInput}},
      //     { path: 'equipSearch', components: {equip :equipSearch}},
      //     { path: 'equipMap', components: {equip :EquipMap}},
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
  created() {
    let uName = getCookie('username');
    let uPwd = getCookie('info');
    if(uName === ""){
      router.push('/');
    }else {
      let data = {'username':uName,'password':uPwd};
      this.$http.post('./php/login.php', data,{emulateJSON:true}).then((res)=>{
        if(res.data === '1'){
          router.push('/admin');
        }else if(res.data === '2'){
          router.push('/user');
        }else if(res.data === '3'){
          router.push('/serviceman');
        }
      });
    }
  }
});

// router.push('/');
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
