<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data Assessment Task</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">Assessment-Task</li>
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
                                    <a class="dropdown-item" :href="'/api/assessment-task/excel/export/' + user_id" download>Export Excel</a>
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
                                    <option value="user_name asc">Name ASC</option>
                                    <option value="user_name desc">Name DESC</option>
                                    <option value="title asc">Title ASC</option>
                                    <option value="title desc">Title DESC</option>
                                    <option value="score asc">Score ASC</option>
                                    <option value="score desc">Score DESC</option>
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
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>School</th>
                                            <th>Class</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Score</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableSchool">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.sc_school_name}}</td>
                                            <td>{{data.sc_class_name}}</td>
                                            <td>{{data.user_name}}</td>
                                            <td>{{data.title}}</td>
                                            <td>{{data.score}}</td>
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
                                <pagination :data="PaginateSchool" @pagination-change-page="appSchool"></pagination>
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
                            <label for="student_id_add">Student ID</label>
                            <input type="text" class="form-control" id="student_id_add" v-model="addAssessmentTask.sc_student_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="title_add">Title</label>
                            <input type="text" class="form-control" id="title_add" v-model="addAssessmentTask.title">
                        </div>
                        <div class="form-group col-12 float-left">
                            <label for="score_add">Score</label>
                            <input type="text" class="form-control" id="score_add" v-model="addAssessmentTask.score">
                        </div>
                        <div class="form-group col-12 float-left">
                            <label for="description_add">Description</label>
                            <textarea class="form-control" id="description_add" placeholder="Description..." v-model="addAssessmentTask.description"></textarea>
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
                            <label for="student_id">Student ID</label>
                            <input type="text" class="form-control" id="student_id" v-model="editAssessmentTask.sc_student_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" v-model="editAssessmentTask.title">
                        </div>
                        <div class="form-group col-12 float-left">
                            <label for="score">Score</label>
                            <input type="text" class="form-control" id="score" v-model="editAssessmentTask.score">
                        </div>
                        <div class="form-group col-12 float-left">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" placeholder="Description..." v-model="editAssessmentTask.description"></textarea>
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
        document.title = 'Manage Assessment Task';
    },
    data() {
        return {
            user_id : this.$store.state.Users.user.id,
            /*table data*/
            TableSchool: [],
            PaginateSchool: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            /*data for add assessment task*/
            addAssessmentTask : {
            	sc_student_id : '',
            	title : '',
            	description : '',
                score : ''
            },
            /*data for edit school*/
            editAssessmentTask: {
                sc_student_id : '',
                title : '',
                description : '',
                score : ''
            }
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
    			/*window.location.reload();*/
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
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
            }
        },
        /*searching for table*/
        async search(data, paginate = 1) {
            var order = this.table.orderable.split(' ');
            var columns = this.table.columns;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
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
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*choose columns for table*/
        async columns(columns, paginate = 1) {
            var data = this.table.searching;
            var order = this.table.orderable.split(' ');
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/assessment-task?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableSchool = result.data.data;
                    this.PaginateSchool = result.data;
                }).catch(error => {
                    this.Error(error, error.message);
                });
            }
        },
        /*save data for add modal*/
        async createSave() {
        	await axios({
        		url : '/api/assessment-task',
        		method : 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
        		data : {
        			sc_student_id : this.addAssessmentTask.sc_student_id,
        			title : this.addAssessmentTask.title,
        			description : this.addAssessmentTask.description,
                    score : this.addAssessmentTask.score
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
                url: '/api/assessment-task/' + this.editAssessmentTask.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                    sc_student_id : this.editAssessmentTask.sc_student_id,
                    title : this.editAssessmentTask.title,
                    description : this.editAssessmentTask.description,
                    score : this.editAssessmentTask.score
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
                url: '/api/assessment-task/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editAssessmentTask.sc_student_id = val.sc_student_id;
                    this.editAssessmentTask.title = val.title;
                    this.editAssessmentTask.description = val.description;
                    this.editAssessmentTask.score = val.score;
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
                        url: '/api/assessment-task/' + data,
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
