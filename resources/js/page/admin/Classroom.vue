<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Classroom</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Index</a></li>
                            <li class="breadcrumb-item active">Classroom</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown"><button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light btn-rounded dropdown-toggle"><i class="mdi mdi-settings-outline mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated"><a href="#" data-toggle="modal" data-target="#modal-add" class="dropdown-item">Add new data</a>
                                    <div class="dropdown-divider"></div> <a href="#" class="dropdown-item">Import Excel</a> <a href="#" class="dropdown-item">Export Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;"><span>Classroom XI TKJ B.Indonesia</span> </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-sm-12 col-md-3 float-left" v-for="data in study" :key="data.id">
                                        <router-link :to="'/admin/classroom/'+data.id">{{data.name}}</router-link>
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
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            study : []
        }
    },
    created() {
        this.dataStudy();
    },
    methods : {
        /*Error page with refresh*/
        async serverErrorPage(error, message){
            console.error(error);
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                timer: 1500
            });
            setTimeout(function(){
                document.body.style.paddingRight = '0';
            }, 1550);
        },
        /*display error*/
        async Error(error, message){
            console.error(error);
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                timer: 1500
            });
            setTimeout(function(){
                document.body.style.paddingRight = '0';
            }, 1550);
        },
        /*display success*/
        async RequestSuccess(message){
            Swal.fire({
                title: 'Success!',
                text: message,
                icon: 'success',
                timer: 1500
            });
            setTimeout(function(){
                document.body.style.paddingRight = '0';
            }, 1550);
        },
        async dataStudy()
        {
            await axios({
                url : '/api/study/data/school',
                method : 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                this.study = result.data;
            }).catch(error => {
                this.Error(error, error.message);
            })
        }
    }
}

</script>
