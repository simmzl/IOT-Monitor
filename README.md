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
