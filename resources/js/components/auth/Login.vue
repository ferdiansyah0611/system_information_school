<template>
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-sm-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2">
                                    <h5 class="mb-5 text-center">Sign in</h5>
                                    <form class="form-horizontal" @submit.prevent="requestLogin">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group form-group-custom mb-4">
                                                    <input type="number" class="form-control" id="nisn" v-model="login.nisn" required>
                                                    <label for="nisn">NSIN</label>
                                                </div>
                                                <div class="form-group form-group-custom mb-4">
                                                    <input type="password" class="form-control" id="password" v-model="login.password" required autocomplete="off">
                                                    <label for="password">Password</label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="remember">
                                                            <label class="custom-control-label" for="remember">Remember me</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Log In</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    beforeMount() {
        document.title = 'Login';
    },
    mounted() {
        $('#page-topbar').remove();
        $('.vertical-menu').remove();
        $('.footer').remove();
        $('.right-bar').remove();
        $('.rightbar-overlay').remove();
        $('.main-content').css({
            marginLeft: '0',
            overflow: 'hidden'
        });
        $('body').css('background-color', 'aquamarine');
    },
    data() {
        return {
        	login : {
    			nisn : '',
    			password : ''
    		}
        }
    },
    methods: {
    	async requestLogin(){
    		await axios({
    			url : '/api/login',
    			method : 'post',
    			data : {
    				nisn : this.login.nisn,
    				password : this.login.password
    			}
    		}).then(result => {
                this.$store.commit('UsersData', JSON.stringify(result.data));
                window.localStorage.setItem('users', JSON.stringify(result.data));
                if(result.data.user.role == 'admin' || result.data.user.role == 'administrator') {
    			     return window.location.href = '/admin';

                }
                if(result.data.user.role == 'teacher') {
                    return window.location.href = '/teacher';
                }
                if(result.data.user.role == 'teacher') {
                    return window.location.href = '/teacher';
                }
                else{
                    return window.location.href = '/';
                }
    		}).catch(e => {
    			console.error(e.message);
    		});
    	},
    }
}

</script>
