<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Classroom</h4>
                        <ol class="breadcrumb m-0">
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
                                    <form @submit.prevent="createClassroom">
                                        <div class="form-group col-12 float-left">
                                            <label>What do you think ?</label>
                                            <textarea class="form-control" style="min-height: 100px;" v-model="addClassroom.description" required></textarea>
                                        </div>
                                        <div class="form-group col-4 float-left mt-1">
                                            <label>Upload asset</label>
                                            <input class="form-control" type="file" ref="asset" v-on:change="changeAsset()">
                                        </div>
                                        <div class="form-group col-4 float-left mt-1" id="typeClassroom">
                                            <label>Type</label>
                                            <select class="custom-select" v-model="addClassroom.type" required>
                                                <option value="only_post">Only Post</option>
                                                <option value="question">Question</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-4 float-left mt-1" id="teacherData">
                                            <label>Data</label>
                                            <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal-add">Data question</button>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-3 text-center float-right mt-1">
                                            <button type="submit" class="btn btn-info w-100">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card card-default col-md-6 p-0 float-left">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;"><span>Latest Post</span> </div>
                                </div>
                                <div class="card-body">
                                    <div v-for="data in studyID" :key="data.id">
                                        <p><img :src="'/storage/image/' + data.avatar" alt="avatar" class="rounded" width="50px" height="50px"> <span>{{data.name}}</span><span class="float-right">{{data.created_at}}</span></p>
                                        <p>{{data.description}}</p>
                                        <div class="dropdown-divider"></div>
                                        <p class="text-center float-left w-100">
                                            <a href="#" class="icon-link col-6 float-left"><i class="far fa-thumbs-up"></i></a>
                                            <a href="#" class="icon-link col-6 float-left"><i class="fas fa-comment-alt"></i></a>
                                        </p>
                                    </div>
                                    <pagination :data="PaginateClassroomViews" @pagination-change-page="dataStudy"></pagination>
                                </div>
                            </div>
                            <div class="card card-default col-md-5 p-0 float-right">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;"><span>Latest Task</span> </div>
                                </div>
                                <div class="card-body">
                                    <div v-for="data in task" :key="data.id">
                                        <p><img :src="'/storage/image/' + data.avatar" alt="avatar" class="rounded" width="50px" height="50px"> <span>{{data.name}}</span><span class="float-right">{{data.created_at}}</span></p>
                                        <p>{{data.note}}</p>
                                        <p>Last Date : {{data.max_date}}</p>
                                        <button class="btn btn-primary" v-on:click="modalReplyTask">Reply task</button>
                                        <div class="dropdown-divider"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal add -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-add-title">Add data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="quest_choice">
                            <div class="col-12">
                                <label>Max Question</label>
                                <select class="custom-select" v-model="addClassroom.max_question">
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label>Note</label>
                                <textarea class="form-control" v-model="addClassroom.note"></textarea>
                            </div>
                            <div class="col-12">
                                <label>Max date</label>
                                <input type="date" v-model="addClassroom.max_date">
                            </div>
                            <div class="col-12 mb-4">
                                <label>Study</label>
                                <select class="custom-select" v-model="addClassroom.sc_study_id">
                                    <option v-for="data in study" :key="data.id" :value="data.id">{{data.name}}</option>
                                </select>
                            </div>
                        </div>
                        <ckeditor :editor="editor" v-model="addClassroom.question" :config="editorConfig"></ckeditor>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
        </div><div class="modal fade" id="modal-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">Reply Task</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <input type="file" v-model="reply.file">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>
<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            addClassroom : {
                description : '',
                asset : '',
                type : 'only_post',

                sc_teacher_id : '',
                sc_study_id : '',
                question : '<p>Keywords your question...</p>',
                max_question : '',
                max_date : '',
                note : ''
            },
            reply : {
                file : []
            },
            PaginateClassroomViews: {},
            PaginateTask: {},
            study : [],
            studyID : [],
            task : [],
            addQuest_choice : [],
            editor: ClassicEditor,
            editorConfig: {}
        }
    },
    mounted() {
        this.checkRole();
        console.log(this.$route.params.classroom)
    },
    created() {
        this.dataStudy();
    },
    methods : {
        checkRole() {
            var role = this.$store.state.Users.user.role;
            console.log(role)
            if(role !== 'teacher' || role !== 'admin' || role !== 'administrator') {
                document.getElementById('teacherData').style.display = 'none';
                document.getElementById('typeClassroom').style.display = 'none';
                document.getElementById('modal-add').style.innerHTML = '';
            }
            if(role == 'teacher' || role == 'admin' || role == 'administrator') {
                document.getElementById('teacherData').style.display = 'block';
                document.getElementById('typeClassroom').style.display = 'block';
            }
        },
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
        async createClassroom() {
            var formData = new FormData();
            formData.append('description', this.addClassroom.description);
            formData.append('asset', this.addClassroom.asset);
            formData.append('type', this.addClassroom.type);
            formData.append('sc_teacher_id', this.addClassroom.sc_teacher_id);
            formData.append('sc_study_id', this.addClassroom.sc_study_id);
            formData.append('question', this.addClassroom.question);
            formData.append('max_question', this.addClassroom.max_question);
            await axios({
                url : '/api/classroom',
                method : 'post',
                data : formData,
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                this.RequestSuccess(result.data.message);
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        async dataStudy(paginate = 1) {
            var role = this.$store.state.Users.user.role;
            if(role == 'teacher' || role == 'admin' || role == 'administrator') {
                await axios({
                    url : '/api/study/data/school',
                    method : 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.study = result.data.data;
                }).catch(error => {
                    this.Error(error, error.message);
                })
            }
            await axios({
                url :'/api/classroom/' + this.$route.params.classroom,
                method : 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                this.studyID = result.data.post.data
                this.task = result.data.task.data
                this.PaginateClassroomViews = result.data
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        async modalReplyTask() {
            var formData = new FormData();
            formData.append('file', this.reply.file);
            await axios({
                url : '/api/classroom/reply-task',
                data : formData,
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                console.log(result.data);
            }).catch(error => {
                console.error(error.stack)
            })
        },
        /*change event in here...*/
        async changeAsset() {
            this.addClassroom.asset = this.$refs.asset.files[0];
        }
    }
}

</script>
<style scoped>
    .icon-link{
        padding: 0 0 0 20px;
        font-size: 20px;
    }
</style>