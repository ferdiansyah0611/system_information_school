<template>
    <div>
        <div id="layout-wrapper">
            <nav-template></nav-template>
            <side-left-template></side-left-template>
            <!-- content -->
            <div class="main-content">
                <div class="page-content">
	                <transition name="fade" mode="out-in">
						<router-view></router-view>
					</transition>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                2020 © Xoric.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-right d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Ferdiansyah
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <side-right-template></side-right-template>
        <div class="rightbar-overlay"></div>
    </div>
</template>
<script>
import NavTemplate from '../../template/one/Nav';
import SideLeftTemplate from '../../template/one/SideLeft';
/*export*/
export default {
    beforeMount() {
        this.$store.commit('UsersData', JSON.parse(window.localStorage.getItem('users')));
    },
    mounted() {
    },
    /*beforeMount() {
        alert(this.$store.state.Users);
        if(UserData == null){
            return window.location.href = '/login';
        }else{
            return false;
        }
    },*/
    components : {
        NavTemplate, SideLeftTemplate
    }
}

</script>
