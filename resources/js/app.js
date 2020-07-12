require('./bootstrap');

window.Vue = require('vue');


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('agregar-component', require('./components/AgregarComponent.vue').default);

const app = new Vue({
    el: '#app',
});
