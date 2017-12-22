# lab

> A Vue.js project

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report
```

For a detailed explanation on how things work, check out the [guide](http://vuejs-templates.github.io/webpack/) and [docs for vue-loader](http://vuejs.github.io/vue-loader).

## Tips & 坑
### $options
Q：在methods中，一个方法需要调用另一个方法

A:
```javascript
a() {
  console.log("a");
},
b() {
  this.$options.methods.a();
  console.log("b");
}
```
总结：
vm.$options用于当前 Vue 实例的初始化选项。需要在选项中包含自定义属性时会有用处；
[官方文档vm.$options](https://cn.vuejs.org/v2/api/#vm-options)
### git
这个操作慎用，会导致git仓库之前的历史记录全部丢失！
#### 取消本地目录下关联的远程库：
git remote remove origin

#### 在本地目录下关联远程repository ：
git remote add origin git@github.com:username/repository-name.git

### 防止组件style污染全局
使用`scoped`
```html
<style scoped>

</style>
```
### vue-router
#### 引入
```javascript
import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
```
#### 配置
```javascript
import login from './components/login/login';
import signUp from './components/signup/signup';

let routes = [
  { path: '/', component: login },
  { path: '/signUp', component: signUp }
]

let router = new VueRouter({
  linkActiveClass: 'active',
  routes
});
```
#### 挂载和初始化
```javascript
// 挂载
const vm = new Vue({
  router
}).$mount('#app');

// 初始化(默认显示'/')
router.push('/');
```
#### 使用
##### 路由插座
```html
<router-view></router-view>
```
`router-view`有`name`属性，在注册路由时可根据其`name`指定路由对应的`router-view`;
```
<router-view name="test"></router-view>

{ path: '/signUp', components: { test: signUp } }
```
##### keep-alive
```html
<keep-alive>
  <router-view></router-view>
</keep-alive>
```
使用`keep-alive`之后页面模板第一次初始化解析变成HTML片段后，再次进入就不在重新解析而是读取内存中的数据;
### 使用
##### 路由跳转
```html
<router-link to="/">登录</router-link>
<router-link to="/signUp">注册</router-link>
```
### 路由嵌套
使用`children: []`定义子路由
```
{
  path: '/admin',
  component: admin,
  redirect: '/admin/charts',
  children: [
    { path: 'charts', component: charts },
    { path: 'video', component: labVideo }
  ]
}
```
### 使用MD5加密数据
```javascript
// package.json中添加依赖
"dependencies": {
  "md5": "^1.3.0"
}
// 引入
import md from 'md5'
// 加密
md('abcdef');//e80b5017098950fc58aad83c8c14978e
```
MD5反向破解目前来说还是不可能的，目前的碰撞方法是在已有的明文密码基础上制作彩虹表进行反查，所以不要设置常见的简单密码、纯数字或者纯字母等；

### VUE生命周期
在使用路由时，在一个路由中定义了一个定时器，更改路由时，按照官方文档里说，原来的组件已经销毁，但setInterval()依然会不断运行。这里的问题不在于组件是否销毁，因为setInterval事件本身和组件没有关系，和vue的生命周期没有关系。

**那么如何实现在切换路由时clearInterval()？**

vue的生命周期中有`activated`和`deactivated`这两个生命周期钩子函数，当组件在` <keep-alive> `内被切换时，其钩子函数会被对应执行，主要用于保留组件状态或避免重新渲染。
所以，在之前的问题中，使用`<keep-alive>`包裹`<router-view>`路由插座，并在`deactivated`钩子函数中设置`clearInterval()`即可实现在路由切换时清除定时器；

参考：[stackoverflow](https://stackoverflow.com/questions/35104770/how-to-destroy-a-component-when-building-spa-with-vue-js-and-vue-router)
[keep-alive官方文档](https://cn.vuejs.org/v2/api/#keep-alive)
## 后端PHP
### 定时执行PHP程序
php没有自带定时器，在centos系统中可以使用crontab执行php定时任务:

- vi编辑/var/spool/cron下的root文件
- 添加一行, 每一分钟请求一次http://localhost/1.php
```
*/1  * * * * /usr/bin/curl http://localhost/1.php
```
- 重启crond服务
``` 
service crond restart
```
参考：[PHP实现执行定时任务的几种思路详解](https://segmentfault.com/a/1190000002955509)

### 文件上传
关于文件上传功能的实现，我写了一篇博客：[利用FormData对象实现AJAX文件上传功能及后端实现](http://blog.simmzl.cn/2017/12/%E5%88%A9%E7%94%A8FormData%E5%AF%B9%E8%B1%A1%E5%AE%9E%E7%8E%B0AJAX%E6%96%87%E4%BB%B6%E4%B8%8A%E4%BC%A0%E5%8A%9F%E8%83%BD%E5%8F%8A%E5%90%8E%E7%AB%AF%E6%8E%A5%E6%94%B6.html)



