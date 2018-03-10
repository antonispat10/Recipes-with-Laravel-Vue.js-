require('./bootstrap');

window.Vue = require('vue');

let axios = require('axios');

Vue.component('nform', require('./components/NForm.vue'));

const app = new Vue({
    el: '#app'
});
