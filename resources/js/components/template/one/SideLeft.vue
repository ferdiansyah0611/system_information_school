<template>
    <!-- side left -->
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    <li>
                        <router-link to="/admin/dashboard" class="waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-chart-line" style="color: #3051d3;"></i></div><span class="badge badge-pill badge-success float-right">3</span>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-layer-group" style="color: #3051d3;"></i></div>
                            <span>API</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li>
                                <router-link to="/admin/setting/api/client" class="waves-effect">Client</router-link>
                            </li>
                            <li>
                                <router-link to="/admin/setting/api/authorized-token" class="waves-effect">Authorized Client</router-link>
                            </li>
                            <li>
                                <router-link to="/admin/setting/api/personal-token" class="waves-effect">Personal Access Token</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title">Management</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-store-alt" style="color: #3051d3;"></i></div>
                            <span>Class</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Create</a></li>
                            <li>
                                <router-link to="/admin/manage/class" class="waves-effect">Data</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-school" style="color: #3051d3;"></i></div>
                            <span>School</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Create</a></li>
                            <li>
                                <router-link to="/admin/manage/school" class="waves-effect">Data</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-smile" style="color: #3051d3;"></i></div>
                            <span>Student</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Create</a></li>
                            <li>
                                <router-link to="/admin/manage/student" class="waves-effect">Data</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-book" style="color: #3051d3;"></i></div>
                            <span>Study</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Create</a></li>
                            <li>
                                <router-link to="/admin/manage/study" class="waves-effect">Data</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-chalkboard-teacher" style="color: #3051d3;"></i></div>
                            <span>Teacher</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Create</a></li>
                            <li>
                                <router-link to="/admin/manage/teacher" class="waves-effect">Data</router-link>
                            </li>
                            <li>
                                <router-link to="/admin/manage/homeroom-teacher" class="waves-effect">Homeroom</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-title">Assessment Student</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="fas fa-sticky-note" style="color: #3051d3;"></i></div>
                            <span>Assessment Task</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Create</a></li>
                            <li>
                                <router-link to="/admin/manage/assessment-task" class="waves-effect">Data</router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <div class="d-inline-block icons-sm mr-1"><i class="mdi mdi-notebook-multiple" style="color: #3051d3;"></i></div>
                            <span>Report Card</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="true">
                            <li><a href="#">Print</a></li>
                            <li>
                                <router-link to="/admin/manage/report-card" class="waves-effect">Data</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
/*import $ from 'jquery';*/
import metisMenu from 'metismenu';
export default {
    mounted() {
        $(function() {
            /*sidebar*/
            "use strict";
            $("#side-menu").metisMenu(),
                $("#vertical-menu-btn").on("click", function(t) {
                    t.preventDefault(), $("body").toggleClass("sidebar-enable"), 992 <= $(window).width() ? $("body").toggleClass("vertical-collpsed") : $("body").removeClass("vertical-collpsed");
                }),
                $("#sidebar-menu a").each(function() {
                    var t = window.location.href.split(/[?#]/)[0];
                    this.href == t &&
                        ($(this).addClass("active"),
                            $(this).parent().addClass("mm-active"),
                            $(this).parent().parent().addClass("mm-show"),
                            $(this).parent().parent().prev().addClass("mm-active"),
                            $(this).parent().parent().parent().addClass("mm-active"),
                            $(this).parent().parent().parent().parent().addClass("mm-show"),
                            $(this).parent().parent().parent().parent().parent().addClass("mm-active"));
                }),
                $(".navbar-nav a").each(function() {
                    var t = window.location.href.split(/[?#]/)[0];
                    this.href == t &&
                        ($(this).addClass("active"),
                            $(this).parent().addClass("active"),
                            $(this).parent().parent().addClass("active"),
                            $(this).parent().parent().parent().parent().addClass("active"),
                            $(this).parent().parent().parent().parent().parent().addClass("active"),
                            $(this).parent().parent().parent().parent().parent().parent().addClass("active"),
                            $(this).parent().parent().parent().parent().parent().parent().parent().addClass("active"));
                }),
                $(".right-bar-toggle").on("click", function(t) {
                    $("body").toggleClass("right-bar-enabled");
                }),
                $(document).on("click", "body", function(t) {
                    0 < $(t.target).closest(".right-bar-toggle, .right-bar").length || $("body").removeClass("right-bar-enabled");
                }),
                $(".dropdown-menu a.dropdown-toggle").on("click", function(t) {
                    return $(this).next().hasClass("show") || $(this).parents(".dropdown-menu").first().find(".show").removeClass("show"), $(this).next(".dropdown-menu").toggleClass("show"), !1;
                }),
                $(function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }),
                $(function() {
                    $('[data-toggle="popover"]').popover();
                }),
                Waves.init();
        });
    }
}

</script>
