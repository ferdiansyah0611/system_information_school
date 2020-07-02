<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data Study</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">Study</li>
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
                                    <a class="dropdown-item" href="#">Import Excel</a>
                                    <a class="dropdown-item" :href="'/api/study/excel/export/' + user_id" download>Export Excel</a>
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
                                    <option value="sc_class_name asc">Class ASC</option>
                                    <option value="sc_class_name desc">Class DESC</option>
                                    <option value="user_name asc">Username ASC</option>
                                    <option value="user_name desc">Username DESC</option>
                                    <option value="name asc">Name ASC</option>
                                    <option value="name desc">Name DESC</option>
                                    <option value="day asc">Day ASC</option>
                                    <option value="day desc">Day DESC</option>
                                    <option value="time asc">Time ASC</option>
                                    <option value="time desc">Time DESC</option>
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
                                            <th>Class</th>
                                            <th>Teacher</th>
                                            <th>Study</th>
                                            <th>Day</th>
                                            <th>Time</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableStudy">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.sc_school_name}}</td>
                                            <td>{{data.sc_class_name}}</td>
                                            <td>{{data.user_name}}</td>
                                            <td>{{data.name}}</td>
                                            <td>{{data.day}}</td>
                                            <td>{{data.time}}</td>
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
                                <pagination v-if="loading == false" :data="PaginateStudy" @pagination-change-page="appSchool"></pagination>
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
                            <label for="add_teacher_id">Teacher ID</label>
                            <input type="text" class="form-control" id="add_teacher_id" v-model="addStudy.sc_teacher_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_school_id">School ID</label>
                            <input type="text" class="form-control" id="add_school_id" v-model="addStudy.sc_school_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_class_id">Class ID</label>
                            <input type="text" class="form-control" id="add_class_id" v-model="addStudy.sc_class_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_study_name">Name Study</label>
                            <input type="text" class="form-control" id="add_study_name" v-model="addStudy.name">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_day">Day</label>
                            <select class="custom-select" id="add_day" v-model="addStudy.day">
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_time">Hours & Time</label>
                            <input type="text" class="form-control" id="add_time" v-model="addStudy.time">
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
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="teacher_id">Teacher ID</label>
                            <input type="text" class="form-control" id="teacher_id" v-model="editStudy.sc_teacher_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="school_id">School ID</label>
                            <input type="text" class="form-control" id="school_id" v-model="editStudy.sc_school_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="class_id">Class ID</label>
                            <input type="text" class="form-control" id="class_id" v-model="editStudy.sc_class_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="study_name">Name Study</label>
                            <input type="text" class="form-control" id="study_name" v-model="editStudy.name">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="day">Name Study</label>
                            <select class="custom-select" id="day" v-model="editStudy.day">
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="time">Hours & Time</label>
                            <input type="text" class="form-control" id="time" v-model="editStudy.time">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="editSave">Save changes</button>
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
        document.title = 'Manage Study';
    },
    data() {
        return {
            user_id : this.$store.state.Users.user.id,
            /*table data*/
            TableStudy: [],
            PaginateStudy: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            /*data for add study*/
            addStudy : {
            	id: '',
                sc_school_id : '',
                sc_class_id : '',
                sc_teacher_id : '',
                name : '',
                day : '',
                time : ''
            },
            /*data for edit study*/
            editStudy: {
                id: '',
                sc_school_id : '',
            	sc_class_id : '',
            	sc_teacher_id : '',
                name : '',
                day : '',
                time : ''
            },
            loading : false
        }
    },
    created() {
        /*call function default data for table*/
        this.appSchool();
    },
    methods: {
        /*Error page with refresh*/
    	async serverErrorPage(error, message){
    		console.error(error);
    		Swal.fire('Error!', message + '. Please wait for the page to resfresh automatically', 'error');
    		setTimeout(function(){
    			window.location.reload();
    		}, 5000);
    	},
        /*display error*/
    	async Error(error, message){
    		console.error(error);
    		Swal.fire('Error!', message, 'error');
    	},
        /*display success*/
    	async RequestSuccess(message){
    		Swal.fire('Success!', message, 'success');
    		setTimeout(function(){
            document.body.style.paddingRight = '0';

    		}, 5000);
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
                    url: '/api/study?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/study?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
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
                    url: '/api/study?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/study?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
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
                    url: '/api/study?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/study?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
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
                    url: '/api/study?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/study?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudy = result.data.data;
                    this.PaginateStudy = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*save data for add modal*/
        async createSave() {
        	await axios({
        		url : '/api/study',
        		method : 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
        		data : {
                    sc_school_id : this.addStudy.sc_school_id,
                    sc_class_id : this.addStudy.sc_class_id,
                    sc_teacher_id : this.addStudy.sc_teacher_id,
                    name : this.addStudy.name,
                    day : this.addStudy.day,
                    time : this.addStudy.time,
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
            await axios({
                url: '/api/study/' + this.editStudy.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                	sc_school_id : this.editStudy.sc_school_id,
                    sc_class_id : this.editStudy.sc_class_id,
                    sc_teacher_id : this.editStudy.sc_teacher_id,
                    name : this.editStudy.name,
                    day : this.editStudy.day,
                    time : this.editStudy.time,
                }
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
                url: '/api/study/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editStudy.id = val.id;
                    this.editStudy.sc_school_id = val.sc_school_id;
                    this.editStudy.sc_class_id = val.sc_class_id;
                    this.editStudy.sc_teacher_id = val.sc_teacher_id;
                    this.editStudy.name = val.name;
                    this.editStudy.day = val.day;
                    this.editStudy.time = val.time;
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
                        url: '/api/study/' + data,
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
                    Swal.fire('Cancelled', 'Your data is safe', 'error')
                }
            });
        }
        /*change event in here...*/
        
    }
}

</script>
