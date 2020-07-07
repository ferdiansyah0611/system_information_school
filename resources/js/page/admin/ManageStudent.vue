<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data Student</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">Student</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-md-block">
                            <div class="dropdown">
                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-add">Add new data</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-import">Import Excel</a>
                                    <a class="dropdown-item" :href="'/api/student/excel/export/' + user.id + '/' + user.email" download>Export Excel</a>
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
                    <div class="card col-12">
                        <div class="card-body">
                            <div class="col-sm-12 col-md-4 float-left">
                                <input v-model="table.searching" @keyup="search($event.target.value)" type="search" name="search" class="form-control" placeholder="Search data..." autocomplete="off">
                            </div>
                            <div class="col-sm-12 col-md-4 float-left">
                                <select v-model="table.orderable" @change="orderby($event.target.value)" class="custom-select">
                                    <option selected="" value="id asc">ID ASC</option>
                                    <option value="id desc">ID DESC</option>
                                    <option value="sc_school_name asc">School ASC</option>
                                    <option value="sc_school_name desc">School DESC</option>
                                    <option value="nisn asc">NISN ASC</option>
                                    <option value="nisn desc">NISN DESC</option>
                                    <option value="user_name asc">Name ASC</option>
                                    <option value="user_name desc">Name DESC</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 float-left">
                                <select v-model="table.columns" @change="columns($event.target.value)" class="custom-select">
                                    <option value="10">10</option>
                                    <option selected="" value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="table-responsive">
                                <div v-if="loading" class="d-flex justify-content-center mt-4">
                                    <div class="spinner-grow text-danger mr-2 mt-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-warning mr-2 mt-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div class="spinner-grow text-success mr-2 mt-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <table v-if="loading == false" class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School</th>
                                            <th>NISN</th>
                                            <th>Name</th>
                                            <th>Generation</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableStudent">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.sc_school_name}}</td>
                                            <td>{{data.nisn}}</td>
                                            <td>{{data.user_name}}</td>
                                            <td>{{data.generation}}</td>
                                            <th>{{data.updated_at}}</th>
                                            <th>
                                                <button class="btn btn-primary btn-sm waves-effect waves-light" v-on:click="editRequest(data.id)">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm waves-effect waves-light" v-on:click="deleted(data.id)">
                                                    <i class="mdi mdi-plus-box-outline"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                                <pagination v-if="loading == false" :data="PaginateStudent" @pagination-change-page="appSchool"></pagination>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal add -->
        <div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modal-add-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-add-title">Add data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="user00-add">User ID</label>
                            <input type="number" class="form-control" id="user00-add" required v-model="addStudent.user_id" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="school00-add">School</label>
                            <select class="custom-select" id="school00-add" required v-model="addStudent.sc_school_id" required>
                                <option v-for="data in school" :key="data.id" :value="data.id">{{data.name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="class00-add">Class</label>
                            <input type="number" class="form-control" id="class00-add" required v-model="addStudent.sc_class_id" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="nisn-add">NISN</label>
                            <input type="number" class="form-control" id="nisn-add" required v-model="addStudent.nisn" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone-add">Phone</label>
                            <input type="number" class="form-control" id="phone-add" required v-model="addStudent.phone" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="father-add">Father</label>
                            <input type="text" class="form-control" id="father-add" required v-model="addStudent.father" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="mother-add">Mother</label>
                            <input type="text" class="form-control" id="mother-add" required v-model="addStudent.mother" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="work-father-add">Work Father</label>
                            <input type="text" class="form-control" id="work-father-add" required v-model="addStudent.work_father" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="work-mother-add">Work Mother</label>
                            <input type="text" class="form-control" id="work-mother-add" required v-model="addStudent.work_mother" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone-father-add">Phone Father</label>
                            <input type="number" class="form-control" id="phone-father-add" required v-model="addStudent.phone_father" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone-mother-add">Phone Mother</label>
                            <input type="number" class="form-control" id="phone-mother-add" required v-model="addStudent.phone_mother" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="generation-add">Generation</label>
                            <input type="text" class="form-control" id="generation-add" required v-model="addStudent.generation" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="avatars-add">Avatars</label>
                            <input type="file" class="form-control" id="avatars-add" ref="file" v-on:change="changeFile()" accept=".png,.jpg,.jpeg">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="createSave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal edit -->
        <div class="modal fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="modal-1-title" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-1-title">Edit data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-sm-12 col-md-6 float-left text-center" v-if="editStudent.avatar">
                            <img :src="'/storage/image/' + editStudent.avatar" height="200px" class="img-thumbnail">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="user00">User ID</label>
                            <input type="number" class="form-control" id="user00" required v-model="editStudent.user_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="school00">School</label>
                            <select class="custom-select" id="school00" required v-model="editStudent.sc_school_id">
                                <option v-for="data in school" :key="data.id" :value="data.id">{{data.name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="class00">Class</label>
                            <input type="number" class="form-control" id="class00" required v-model="editStudent.sc_class_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="nisn">NISN</label>
                            <input type="number" class="form-control" id="nisn" required v-model="editStudent.nisn">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone">Phone</label>
                            <input type="number" class="form-control" id="phone" required v-model="editStudent.phone">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="father">Father</label>
                            <input type="text" class="form-control" id="father" required v-model="editStudent.father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="mother">Mother</label>
                            <input type="text" class="form-control" id="mother" required v-model="editStudent.mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="work-father">Work Father</label>
                            <input type="text" class="form-control" id="work-father" required v-model="editStudent.work_father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="work-mother">Work Mother</label>
                            <input type="text" class="form-control" id="work-mother" required v-model="editStudent.work_mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone-father">Phone Father</label>
                            <input type="number" class="form-control" id="phone-father" required v-model="editStudent.phone_father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone-mother">Phone Mother</label>
                            <input type="number" class="form-control" id="phone-mother" required v-model="editStudent.phone_mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="generation">Generation</label>
                            <input type="text" class="form-control" id="generation" required v-model="editStudent.generation">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="avatars">Avatars</label>
                            <input type="file" class="form-control" id="avatars" ref="fileEdit" v-on:change="changeFileUpdate()" accept=".png,.jpg,.jpeg">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="editSave">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal import -->
        <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-import-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-import-title">Import data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="imports">File format .xls / .xlsx</label>
                        <input type="file" ref="fileImport" v-on:change="changeFileImport()" class="form-control" id="imports" accept=".xls,.xlsx">
                        <button class="btn btn-primary mt-2" @click="importData">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import Swal from 'sweetalert2';

export default {
    beforeMount() {
        document.title = 'Manage Student';
    },
    data() {
        return {
            user : this.$store.state.Users.user,
            /*table data*/
            TableStudent: [],
            PaginateStudent: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            /*data api school*/
            school: {},
            /*data for add student*/
            addStudent: {
                id: '',
                user_id: '',
                sc_school_id: '',
                sc_class_id: '',
                nisn: '',
                phone: '',
                father: '',
                mother: '',
                work_father: '',
                work_mother: '',
                phone_father: '',
                phone_mother: '',
                generation: '',

                file: ''
            },
            /*data for edit student*/
            editStudent: {
                id: '',
                user_id: '',
                sc_school_id: '',
                sc_class_id: '',
                phone: '',
                nisn: '',
                father: '',
                mother: '',
                work_father: '',
                work_mother: '',
                phone_father: '',
                phone_mother: '',
                generation: '',
                file: '',
                avatar: ''
            },
            imports: '',
            loading : false
        }
    },
    created() {
        /*call function default data for table*/
        this.appSchool();
        /*call function api school*/
        this.schoolData();
    },
    methods: {
        /*Error page with refresh*/
        async serverErrorPage(error, message){
            console.error(error);
            Swal.fire({
                title: 'Error!',
                text: message + '. Please wait for the page to resfresh automatically',
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
        /*default for table*/
        async appSchool(paginate = 1) {
            var data = this.table.searching;
            var order = this.table.orderable.split(' ');
            var columns = this.table.columns;
            this.loading = true;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
            }
        },
        /*searching for table*/
        async search(data, paginate = 1) {
            var order = this.table.orderable.split(' ');
            var columns = this.table.columns;
            this.loading = true;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*orderby for table*/
        async orderby(order, paginate = 1) {
            var data = this.table.searching;
            var type = order.split(' ');
            var columns = this.table.columns;
            this.loading = true;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*choose columns for table*/
        async columns(columns, paginate = 1) {
            var data = this.table.searching;
            var order = this.table.orderable.split(' ');
            this.loading = true;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*request api in here*/
        /*api school*/
        async schoolData() {
            await axios({
                url: '/api/school?type=default',
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token,
                    'Content-Type' : 'multipart/form-data'
                }
            }).then(result => {
                this.school = result.data.data;
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*save data for add modal*/
        async createSave() {
            var formData = new FormData();
            formData.append('file', this.addStudent.file);
            formData.append('user_id', this.addStudent.user_id);
            formData.append('sc_school_id', this.addStudent.sc_school_id);
            formData.append('sc_class_id', this.addStudent.sc_class_id);
            formData.append('phone', this.addStudent.phone);
            formData.append('nisn', this.addStudent.nisn);
            formData.append('father', this.addStudent.father);
            formData.append('mother', this.addStudent.mother);
            formData.append('work_father', this.addStudent.work_father);
            formData.append('work_mother', this.addStudent.work_mother);
            formData.append('phone_father', this.addStudent.phone_father);
            formData.append('phone_mother', this.addStudent.phone_mother);
            formData.append('generation', this.addStudent.generation);
            await axios.post('/api/student', formData, {
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-add').modal('hide');
                this.RequestSuccess(result.data.message);
                /*refresh*/
                this.appSchool();
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*save data for edit modal*/
        async editSave() {
            var formData = new FormData();
            formData.append('file', this.editStudent.file);
            formData.append('user_id', this.editStudent.user_id);
            formData.append('sc_school_id', this.editStudent.sc_school_id);
            formData.append('sc_class_id', this.editStudent.sc_class_id);
            formData.append('phone', this.editStudent.phone);
            formData.append('nisn', this.editStudent.nisn);
            formData.append('father', this.editStudent.father);
            formData.append('mother', this.editStudent.mother);
            formData.append('work_father', this.editStudent.work_father);
            formData.append('work_mother', this.editStudent.work_mother);
            formData.append('phone_father', this.editStudent.phone_father);
            formData.append('phone_mother', this.editStudent.phone_mother);
            formData.append('generation', this.editStudent.generation);
            await axios({
                url: '/api/student/update/' + this.editStudent.id,
                method: 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: formData
            }).then(result => {
                $('#modal-1').modal('hide');
                this.RequestSuccess(result.data.message);
                /*refresh*/
                this.appSchool();
            }).catch(error => {
                this.Error(error, error.message);
            })
        },
        /*edit/get data on click for table*/
        async editRequest(id) {
            await axios({
                url: '/api/student/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editStudent.id = val.id;
                    this.editStudent.user_id = val.user_id;
                    this.editStudent.sc_school_id = val.sc_school_id;
                    this.editStudent.sc_class_id = val.sc_class_id;
                    this.editStudent.nisn = val.nisn;
                    this.editStudent.avatar = val.avatar;
                    this.editStudent.phone = val.phone;
                    this.editStudent.father = val.father;
                    this.editStudent.mother = val.mother;
                    this.editStudent.work_father = val.work_father;
                    this.editStudent.work_mother = val.work_mother;
                    this.editStudent.phone_father = val.phone_father;
                    this.editStudent.phone_mother = val.phone_mother;
                    this.editStudent.generation = val.generation;
                });
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*delete data on click for table*/
        deleted(id) {
            var data = id;
            Swal.fire({
                title: 'Are you sure',
                text: 'You will not be able to recover this data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then(result => {
                if (result.value) {
                    return axios({
                        url: '/api/student/' + data,
                        method: 'delete',
                        headers : {
                            'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                        }
                    }).then(result => {
                        this.RequestSuccess(result.data.message);
                        /*refresh*/
                        this.appSchool();
                    }).catch(error => {
                        this.Error(error, error.message);
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: 'Cancelled!',
                        text: 'Your data is safe',
                        icon: 'error',
                        timer: 1500
                    });
                    setTimeout(function(){
                        document.body.style.paddingRight = '0';
                    }, 1550);
                }
            });
        },
        async importData() {
            var formData = new FormData();
            formData.append('import', this.imports);
            await axios({
                url : '/api/student/excel/import/' + this.user.id,
                method : 'post',
                data : formData,
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-import').modal('hide');
                this.RequestSuccess(result.data.message);
            }).catch(error => {
                this.Error(error, error.message);
            })
        },
        /*change event in here...*/
        changeFile() {
            this.addStudent.file = this.$refs.file.files[0];
        },
        changeFileUpdate() {
            this.editStudent.file = this.$refs.fileEdit.files[0];
        }
    }
}

</script>