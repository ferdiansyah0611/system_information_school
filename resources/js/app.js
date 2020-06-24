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
Vue.use(VueRouter, VueAxios, Axios);
Vue.component('pagination', require('laravel-vue-pagination'));

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// component in here
Vue.component('nav-template', require('./components/template/one/Nav').default);
Vue.component('side-left-template', require('./components/template/one/SideLeft').default);
Vue.component('side-right-template', require('./components/template/one/SideRight').default);

// data in here
import Store from './store.js';
// page in heres
import App from './page/admin/Index.vue';
import Dashboard from './page/admin/Dashboard.vue';
import ManageClass from './page/admin/Manageclass.vue';
import ManageSchool from './page/admin/ManageSchool.vue';
import ManageStudent from './page/admin/ManageStudent.vue';
import ManageStudy from './page/admin/ManageStudy.vue';
// route in here
const routes = [
    {
        name : 'index',
        path : '/',
        title : 'Resellers Application',
        component: Dashboard
    },
    {
    	name : 'dashboard',
    	path : '/dashboard',
    	title : 'Dashboard',
    	component : Dashboard
    },
    {
    	name : 'manageclass',
    	path : '/manage/class',
    	title : 'Management Class',
    	component : ManageClass
    },
    {
    	name : 'manageSchool',
    	path : '/manage/school',
    	title : 'Management School',
    	component : ManageSchool
    },
    {
        name : 'manageStudent',
        path : '/manage/student',
        title : 'Management Student',
        component : ManageStudent
    },
    {
        name : 'manageStudy',
        path : '/manage/study',
        title : 'Management Study',
        component : ManageStudy
    }
    /*{
        name : 'login',
        path : '/login',
        title : 'Authenticate Resellers',
        component : login
    },
    {
        name : 'showProduct',
        path : '/products/:product',
        title : 'View Products',
        component: viewProduct,
        params : true
    },
    {
        name : 'showCategory',
        path: '/category/:category',
        title : 'Show category',
        component: viewCategory,
        params : true
    },*/
];
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
const app = new Vue(
    Vue.util.extend({
        router,
        store:Store
    }, App)
).$mount('#app');