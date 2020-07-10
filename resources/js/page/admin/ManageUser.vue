<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data User</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">User</li>
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
                                    <a class="dropdown-item" :href="'/api/data-user/excel/export/' + user.id + '/' + user.email" download>Export Excel</a>
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
                                    <option value="sc_school_id asc">School ASC</option>
                                    <option value="sc_school_id desc">School DESC</option>
                                    <option value="name asc">Name ASC</option>
                                    <option value="name desc">Name DESC</option>
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
                                            <th>Name</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableUser">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.sc_school_id}}</td>
                                            <td>{{data.name}}</td>
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
                                <pagination v-if="loading == false" :data="PaginateUser" @pagination-change-page="appClass"></pagination>
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
                            <label for="school-add">School</label>
                            <select class="custom-select" id="school-add" v-model="addUser.sc_school_id" required>
                                <option selected="" disabled="">Choose school</option>
                                <option v-for="data in school" :key="data.id" :value="data.id">{{data.name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="name-add">Name</label>
                            <input type="text" class="form-control" id="name-add" v-model="addUser.name" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="email-add">Email</label>
                            <input type="email" class="form-control" id="email-add" v-model="addUser.email" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="nisn-add">NISN</label>
                            <input type="number" class="form-control" id="nisn-add" v-model="addUser.nisn" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="password-add">Password</label>
                            <input type="password" class="form-control" id="password-add" v-model="addUser.password" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="role-add">Role</label>
                            <select class="custom-select" id="role-add" v-model="addUser.role" required>
                                <option value="administrator">Administrator</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="location-add">Location</label>
                            <input type="text" class="form-control" id="location-add" v-model="addUser.location" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="born-add">Born</label>
                            <input type="date" class="form-control" id="born-add" v-model="addUser.born" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="languange-add">Languange</label>
                            <input type="text" class="form-control" id="languange-add" v-model="addUser.languange" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="gender-add">Gender</label>
                            <select class="custom-select" id="gender-add" v-model="addUser.gender" required>
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-12 float-left">
                            <label for="avatar-add">Avatar</label>
                            <input type="file" id="avatar-add" ref="file" v-on:change="changeFile()" accept=".jpg,.jpeg,.png">
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
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="modal-1-title">Edit data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group col-sm-12 col-md-6 float-left text-center" v-if="editUser.avatar">
                            <img :src="'/storage/image/' + editUser.avatar" height="200px" class="img-thumbnail">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="school-edit">School</label>
                            <select class="custom-select" id="school-edit" v-model="editUser.sc_school_id" required>
                                <option selected="" disabled="">Choose school</option>
                                <option v-for="data in school" :key="data.id" :value="data.id">{{data.name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="name-edit">Name</label>
                            <input type="text" class="form-control" id="name-edit" v-model="editUser.name" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="email-edit">Email</label>
                            <input type="email" class="form-control" id="email-edit" v-model="editUser.email" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="nisn-edit">NISN</label>
                            <input type="number" class="form-control" id="nisn-edit" v-model="editUser.nisn" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="role-edit">Role</label>
                            <select class="custom-select" id="role-edit" v-model="editUser.role" required>
                                <option value="administrator">Administrator</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="location-edit">Location</label>
                            <input type="text" class="form-control" id="location-edit" v-model="editUser.location" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="born-edit">Born</label>
                            <input type="date" class="form-control" id="born-edit" v-model="editUser.born" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="languange-edit">Languange</label>
                            <input type="text" class="form-control" id="languange-edit" v-model="editUser.languange" required>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="gender-edit">Gender</label>
                            <select class="custom-select" id="gender-edit" v-model="editUser.gender" required>
                                <option value="male" selected>Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-12 float-left">
                            <label for="avatar-edit">Avatar</label>
                            <input type="file" id="avatar-edit" ref="fileEdit" v-on:change="changeFileUpdate()" accept=".jpg,.jpeg,.png">
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
        document.title = 'Manage Class';
    },
    data() {
        return {
            user : this.$store.state.Users.user,
            /*table data*/
            TableUser: [],
            PaginateUser: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            /*data api fro school*/
            school: {},
            /*data for add class*/
            addUser: {
                id : '',
                sc_school_id: '',
                name: '',
                email: '',
                nisn: '',
                password: '',
                role: '',
                location: '',
                born: '',
                languange: '',
                gender: '',
                file: ''
            },
            /*data for edit class*/
            editUser: {
                id : '',
                sc_school_id: '',
                name: '',
                email: '',
                nisn: '',
                role: '',
                location: '',
                born: '',
                languange: '',
                gender: '',
                file: '',

                avatar: ''
            },
            imports: '',
            loading : false
        }
    },
    created() {
        /*call function default data for table*/
        this.appClass();
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
        async appClass(paginate = 1) {
            var data = this.table.searching;
            var order = this.table.orderable.split(' ');
            var columns = this.table.columns;
            this.loading = true;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/data-user?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/data-user?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
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
                    url: '/api/data-user?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/data-user?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
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
                    url: '/api/data-user?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/data-user?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
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
                    url: '/api/data-user?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/data-user?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.PaginateUser = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*api school*/
        async schoolData() {
            if(this.$store.state.School.to == undefined){
                await axios({
                    url: '/api/school?type=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.school = result.data.data;
                    this.$store.commit('SchoolData', result.data);
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }else{
                this.school = this.$store.state.School.data;
            }
        },
        /*save data for add modal*/
        async createSave() {
            var formData = new FormData();
            formData.append('sc_school_id', this.addUser.sc_school_id);
            formData.append('name', this.addUser.name);
            formData.append('email', this.addUser.email);
            formData.append('nisn', this.addUser.nisn);
            formData.append('password', this.addUser.password);
            formData.append('role', this.addUser.role);
            formData.append('location', this.addUser.location);
            formData.append('born', this.addUser.born);
            formData.append('languange', this.addUser.languange);
            formData.append('gender', this.addUser.gender);
            formData.append('file', this.addUser.file);
        	await axios({
        		url : '/api/data-user',
        		method : 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
        		data : formData
        	}).then(result => {
        		$('#modal-add').modal('hide');
                this.RequestSuccess(result.data.message);
                /*refresh*/
                this.appClass();
        	}).catch(error => {
        		this.Error(error, error.message);
        	});
        },
        /*save data for edit modal*/
        async editSave() {
            var formData = new FormData();
            formData.append('sc_school_id', this.editUser.sc_school_id);
            formData.append('name', this.editUser.name);
            formData.append('email', this.editUser.email);
            formData.append('nisn', this.editUser.nisn);
            formData.append('password', this.editUser.password);
            formData.append('role', this.editUser.role);
            formData.append('location', this.editUser.location);
            formData.append('born', this.editUser.born);
            formData.append('languange', this.editUser.languange);
            formData.append('gender', this.editUser.gender);
            formData.append('file', this.editUser.file);
            await axios({
                url: '/api/data-user/update/' + this.editUser.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: formData
            }).then(result => {
                $('#modal-1').modal('hide');
                this.RequestSuccess(result.data.message);
                /*refresh*/
                this.appClass();
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*edit/get data on click for table*/
        async editRequest(id) {
            await axios({
                url: '/api/data-user/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editUser.id = val.id;
                    this.editUser.sc_school_id = val.sc_school_id;
                    this.editUser.name = val.name;
                    this.editUser.email = val.email;
                    this.editUser.nisn = val.nisn;
                    this.editUser.role = val.role;
                    this.editUser.location = val.location;
                    this.editUser.born = val.born;
                    this.editUser.languange = val.languange;
                    this.editUser.gender = val.gender;
                    this.editUser.avatar = val.avatar;
                    this.editUser.updated_at = val.updated_at;
                });
            }).catch(error => {
                this.Error(error, error.message);
            })
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
                        url: '/api/data-user/' + data,
                        method: 'delete',
                        headers : {
                            'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                        }
                    }).then(result => {
                    	this.RequestSuccess(result.data.message);
                        /*refresh*/
                        this.appClass();
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
                url : '/api/data-user/excel/import/' + this.user.id,
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
        },
        async changeFileImport() {
            this.imports = this.$refs.fileImport.files[0];
        }
    }
}

</script>
