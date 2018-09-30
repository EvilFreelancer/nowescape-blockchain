import Vue from 'vue';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import BootstrapVue from 'bootstrap-vue'

// Main application
import App from './App';
import Currencies from './components/Currencies';

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue
    .use(BootstrapVue)
    .use(VueRouter)
    .use(VueResource);

// Default configs
Vue.prototype.API = 'http://localhost/api';

const routes = [
    {path: '/', component: Currencies},
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

new Vue({
    router: router,
    render: h => h(App)
}).$mount('#app');
