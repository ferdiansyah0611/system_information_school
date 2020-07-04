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

// component in here
/*Vue.component('passport-clients', require('./components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue'));*/

/*Vue.component('nav-template', require('./components/template/one/Nav').default);*/
/*Vue.component('side-left-template', require('./components/template/one/SideLeft').default);*/
Vue.component('side-right-template', require('./components/template/one/SideRight').default);

// data in here
import Store from './store.js';
// page in heres
import App from './page/Index.vue';
// admin
import TemplateAdmin from './components/template/one/Template.vue';
import Dashboard from './page/admin/Dashboard.vue';
import ManageClass from './page/admin/Manageclass.vue';
import ManageSchool from './page/admin/ManageSchool.vue';
import ManageStudent from './page/admin/ManageStudent.vue';
import ManageStudy from './page/admin/ManageStudy.vue';
import ManageTeacher from './page/admin/ManageTeacher.vue';
import ManageAssessmentTask from './page/admin/ManageAssessmentTask.vue';
import ManageScHomeRoomTeacher from './page/admin/ManageScHomeRoomTeacher.vue';
import ManageReportCard from './page/admin/ManageReportCard.vue';
// teacher
import TemplateTeacher from './components/template/one/Template.vue';
// authenticate
import Login from './components/auth/Login.vue';
import Client from './page/api/Client.vue';
import AuthorizedClient from './page/api/AuthorizedClient.vue';
import PersonalToken from './page/api/PersonalToken.vue';

// route in here
const routes = [{
        name: 'index',
        path: '/',
        component: App
    },
    /*admin*/
    {
        name: 'admin',
        path: '/admin',
        component: TemplateAdmin,
        beforeEnter(to, from, next) {
            let User = JSON.parse(window.localStorage.getItem('users'));
            if (User && User.user.role == 'admin') {
                next();
            }
            if(User && User.user.role == 'administrator') {
                next();
            }
            if(User == null) {
                next('/login');
            }
        },
        children: [{
                path: 'dashboard',
                component: Dashboard
            },
            {
                path: 'manage/class',
                component: ManageClass
            },
            {
                path: 'manage/school',
                component: ManageSchool
            },
            {
                path: 'manage/student',
                component: ManageStudent
            },
            {
                path: 'manage/study',
                component: ManageStudy
            },
            {
                path: 'manage/teacher',
                component: ManageTeacher
            },
            {
                path: 'manage/assessment-task',
                component: ManageAssessmentTask
            },
            {
                path: 'manage/homeroom-teacher',
                component: ManageScHomeRoomTeacher
            },
            {
                path: 'manage/report-card',
                component: ManageReportCard
            },
            {
                path: 'setting/api/client',
                component: Client
            },
            {
                path: 'setting/api/authorized-token',
                component: AuthorizedClient
            },
            {
                path: 'setting/api/personal-token',
                component: PersonalToken
            },
        ]
    },
    {
        name: 'teacher',
        path: '/teacher',
        component: TemplateTeacher,
        beforeEnter(to, from, next) {
            let User = JSON.parse(window.localStorage.getItem('users'));
            if (User && User.user.role == 'teacher') {
                next();
            }
            if(User == null) {
                next('/login');
            }
        }
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        beforeEnter(to, from, next) {
            let User = JSON.parse(window.localStorage.getItem('users'));
            if (User && User.user.id !== undefined) {
                if(User.user.role == 'admin'){
                    next('/admin/dashboard');
                }else{
                    next('/');
                }
            } else {
                next();
            }
        }
    },
    /*{
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
        store: Store
    }, App)
).$mount('#app');
