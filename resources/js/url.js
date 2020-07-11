import SearchData from './page/Search.vue';
import Error404 from './components/404.vue';
// admin {teacher}
import TemplateAdmin from './components/template/one/Template.vue';
import Dashboard from './page/admin/Dashboard.vue';
import ManageClass from './page/admin/Manageclass.vue';
import ManageSchool from './page/admin/ManageSchool.vue';
import ManageStudent from './page/admin/ManageStudent.vue';
import ManageAbsentStudent from './page/admin/ManageAbsentStudent.vue';
import ManageStudy from './page/admin/ManageStudy.vue';
import ManageTeacher from './page/admin/ManageTeacher.vue';
import ManageUser from './page/admin/ManageUser.vue';
import ManageAssessmentTask from './page/admin/ManageAssessmentTask.vue';
import ManageScHomeRoomTeacher from './page/admin/ManageScHomeRoomTeacher.vue';
import ManageReportCard from './page/admin/ManageReportCard.vue';
// teacher
import TemplateTeacher from './components/template/teacher/Template.vue';
// student
import TemplateStudent from './components/template/student/Template.vue';
import DashboardStudent from './page/student/Dashboard.vue';
// authenticate
import Login from './components/auth/Login.vue';
import Client from './page/api/Client.vue';
import AuthorizedClient from './page/api/AuthorizedClient.vue';
import PersonalToken from './page/api/PersonalToken.vue';

const Route = [{
        name: 'index',
        path: '/',
        component: Login,
        beforeEnter(to, from, next) {
            let User = JSON.parse(window.localStorage.getItem('users'));
            if (User && User.user.id !== undefined) {
                if(User.user.role == 'admin' || User.user.role == 'administrator'){
                    next('/admin/dashboard');
                }
                if(User.user.role == 'teacher'){
                    next('/teacher/dashboard');
                }
                if(User.user.role == undefined && User.user.role !== 'admin' && User.user.role !== 'administrator' && User.user.role == 'teacher') {
                    next('/404');

                }
            }
            if(User == null) {
                next();
            }
        }
    },
    {
        path: '/404',
        component: Error404
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
            if (User && User.user.role == 'student') {
                next('/student');
            }
            if(User == null) {
                next('/');
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
                path: 'manage/absent-student',
                component: ManageAbsentStudent
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
                path: 'manage/user',
                component: ManageUser
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
            {
                path : 'search/:search',
                component: SearchData,
                params : true,
            }
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
            if (User && User.user.role == 'student') {
                next('/student');
            }
            if(User == null) {
                next('/login');
            }
        },
        children : [{
                path: 'dashboard',
                component: Dashboard
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
                path: 'manage/assessment-task',
                component: ManageAssessmentTask
            },
            {
                path: 'manage/report-card',
                component: ManageReportCard
            },
            {
                path : 'search/:search',
                component: SearchData,
                params : true,
            }
        ]
    },
    {
        name: 'student',
        path: '/student',
        component: TemplateStudent,
        beforeEnter(to, from, next) {
            let User = JSON.parse(window.localStorage.getItem('users'));
            if (User && User.user.role == 'student') {
                next();
            }
            if(User && User.user.role == 'administrator' || User.user.role == 'admin') {
                next('/admin');
            }
            if(User == null) {
                next('/login');
            }
        },
        children : [{
            path: 'dashboard',
            component: DashboardStudent
        }]
    }
];

export default Route;