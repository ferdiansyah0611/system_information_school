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
                                    Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
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
        document.title = 'Welcome';
        var _parse = JSON.parse(window.localStorage.getItem('users'));
        this.$store.commit('UsersData', _parse);
        axios({
            methods : 'get',
            url : '/api/user',
            headers : {
                'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
            }
        }).then(result => {
            this.$store.commit('UsersData', {
                success : {
                    token : _parse.success.token
                },
                user : result.data
            });
        }).catch(e => {
            console.error(e.message);
        });
    },
    components : {
        NavTemplate, SideLeftTemplate
    }
}

</script>
