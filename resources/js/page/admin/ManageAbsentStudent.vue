<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data Absent Student</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">Absent Student</li>
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
                                    <a class="dropdown-item" :href="'/api/absent-student/excel/export/' + user.id + '/' + user.email" download>Export Excel</a>
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
                                    <option value="user_name asc">Name ASC</option>
                                    <option value="user_name desc">Name DESC</option>
                                    <option value="status asc">Status ASC</option>
                                    <option value="status desc">Status DESC</option>
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
                                            <th>Status</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableAbsentStudent">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.sc_school_name}}</td>
                                            <td>{{data.user_name}}</td>
                                            <td>{{data.status}}</td>
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
                                <pagination v-if="loading == false" :data="PaginateAbsentStudent" @pagination-change-page="appClass"></pagination>
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
                        <div class="form-group float-left col-sm-12 col-md-6">
                            <label for="student-edit">Student ID</label>
                            <input type="number" class="form-control" id="student-edit" v-model="addAbsentStudent.sc_student_id" required>
                        </div>
                        <div class="form-group float-left col-sm-12 col-md-6">
                            <label for="date-add">Date</label>
                            <input type="date" class="form-control" id="date-add" v-model="addAbsentStudent.date" required>
                        </div>
                        <div class="form-group float-left col-12">
                            <label for="date-add">Status</label>
                            <select class="custom-select" id="status-add" v-model="addAbsentStudent.status" required>
                                <option selected="" disabled="">Choose one</option>
                                <option value="present">Present</option>
                                <option value="no present">No Present</option>
                                <option value="permission">Permission</option>
                                <option value="no information">No Information</option>
                            </select>
                        </div>
                        <div class="form-group float-left col-12">
                            <label for="date-add">Opinion</label>
                            <textarea class="form-control" id="opinion-add" v-model="addAbsentStudent.opinion"></textarea>
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
                        <div class="form-group float-left col-sm-12 col-md-6">
                            <label for="student-edit">Student ID</label>
                            <input type="number" class="form-control" id="student-edit" v-model="editAbsentStudent.sc_student_id" required>
                        </div>
                        <div class="form-group float-left col-sm-12 col-md-6">
                            <label for="date-edit">Date</label>
                            <input type="date" class="form-control" id="date-edit" v-model="editAbsentStudent.date" required>
                        </div>
                        <div class="form-group float-left col-12">
                            <label for="date-edit">Status</label>
                            <select class="custom-select" id="status-edit" v-model="editAbsentStudent.status" required>
                                <option value="present">Present</option>
                                <option value="no present">No Present</option>
                                <option value="permission">Permission</option>
                                <option value="no information">No Information</option>
                            </select>
                        </div>
                        <div class="form-group float-left col-12">
                            <label for="date-edit">Opinion</label>
                            <textarea class="form-control" id="opinion-edit" v-model="editAbsentStudent.opinion"></textarea>
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
        document.title = 'Manage Absent Student';
    },
    data() {
        return {
            user : this.$store.state.Users.user,
            /*table data*/
            TableAbsentStudent: [],
            PaginateAbsentStudent: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            /*data api fro school*/
            school: {},
            /*data for add class*/
            addAbsentStudent: {
                id : '',
                sc_student_id: '',
                date : '',
                status: '',
                opinion: '',
            },
            /*data for edit class*/
            editAbsentStudent: {
                id: '',
                sc_student_id: '',
                date : '',
                status: '',
                opinion: '',
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
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
                    this.$store.commit('ClassData', result.data);
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
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
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
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
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
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
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/absent-student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableAbsentStudent = result.data.data;
                    this.PaginateAbsentStudent = result.data;
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
        	await axios({
        		url : '/api/absent-student',
        		method : 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
        		data : {
                    sc_student_id: this.addAbsentStudent.sc_student_id,
                    date: this.addAbsentStudent.date,
                    status: this.addAbsentStudent.status,
                    opinion: this.addAbsentStudent.opinion,
        		}
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
            await axios({
                url: '/api/absent-student/' + this.editAbsentStudent.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                    sc_student_id: this.editAbsentStudent.sc_student_id,
                    date: this.editAbsentStudent.date,
                    status: this.editAbsentStudent.status,
                    opinion: this.editAbsentStudent.opinion,
                }
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
                url: '/api/absent-student/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editAbsentStudent.id = val.id;
                    this.editAbsentStudent.sc_student_id = val.sc_student_id;
                    this.editAbsentStudent.date = val.date;
                    this.editAbsentStudent.status = val.status;
                    this.editAbsentStudent.opinion = val.opinion;
                    this.editAbsentStudent.updated_at = val.updated_at;
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
                        url: '/api/absent-student/' + data,
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
                url : '/api/absent-student/excel/import/' + this.user.id,
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
        async changeFileImport() {
            this.imports = this.$refs.fileImport.files[0];
        }
    }
}

</script>
