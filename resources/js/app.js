require('./bootstrap');
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import {router} from './router/paths'
import {store} from './store'

window.Vue = require('vue').default;

Vue.mixin({});

const app = new Vue({
    vuetify,
    store,
    router: router,
    render: h => h(App),
    el: '#app',
});
