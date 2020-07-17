/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// required
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import Vuex from 'vuex';
import CKEditor from '@ckeditor/ckeditor5-vue';
Vue.use(VueRouter, VueAxios, Axios);
Vue.use(CKEditor);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('side-right-template', require('./components/template/one/SideRight').default);

// data in here
import Store from './store.js';
// page in heres
import App from './page/Index.vue';
// route in here
import Url from './url.js'; 

const router = new VueRouter({
    mode: 'history',
    routes: Url
});

const app = new Vue(
    Vue.util.extend({
        router,
        store: Store
    }, App)
).$mount('#app');
