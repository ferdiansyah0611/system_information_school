<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data School</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">School</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-add">Add new data</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Import Excel</a>
                                    <a class="dropdown-item" href="#">Export Excel</a>
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
                                    <option value="user_id asc">User ID ASC</option>
                                    <option value="user_id desc">User ID DESC</option>
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
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User Id</th>
                                            <th>Name</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableSchool">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.user_id}}</td>
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
                        <div class="float-left">
                            <h5 class="card-title">Information</h5>
                            <div class="dropdown-divider"></div>
                            <!-- type -->
                        	<div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="user_id_add">Homeroom Teacher ID</label>
                                <input type="text" class="form-control" id="user_id_add" v-model="addReportCard.sc_home_room_teacher_id">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="user_id_add">sc_student_id</label>
                                <input type="text" class="form-control" id="user_id_add" v-model="addReportCard.sc_student_id">
                            </div>
                            <div class="form-group col-12 float-left">
                                <label for="type_add">Type School</label>
                                <select class="custom-select" id="type_add" v-model="addReportCard.type">
                                    <option value="odd_semester_1">Semester 1 Ganjil</option>
                                    <option value="even_semester_1">Semester 1 Genap</option>
                                    <option value="odd_semester_2">Semester 2 Ganjil</option>
                                    <option value="even_semester_2">Semester 2 Genap</option>
                                </select>
                            </div>
                            <div class="form-group col-12 float-left">
                                <label for="description_add">Description</label>
                                <textarea class="form-control" id="description_add" placeholder="Description..." v-model="addReportCard.description"></textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Absent</label>
                                <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.absent_broken">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Absent Permission</label>
                                <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.absent_permission">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Absent Without Explanation</label>
                                <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.absent_without_explanation">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Personality Behavior</label>
                                <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.personality_behavior">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Personality Diligence</label>
                                <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.personality_diligence">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Personality Neatness</label>
                                <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.personality_neatness">
                            </div>

                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="class_name_add">Personality Neatness</label>
                                <input type="date" class="form-control" id="class_name_add" v-model="addReportCard.period">
                            </div>
                            
                        </div>
                        <div class="float-left">
                            <h5 class="card-title">Senior High School</h5>
                            <div class="dropdown-divider"></div>
                            <!-- senior -->
                            <div id="senior_high_school">
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">sc_student_id</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.sc_student_id">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">sc_study_id</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.sc_study_id">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">score</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.score">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">kkm_k3</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.kkm_k3">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">kkm_k4</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.kkm_k4">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">k3_ph</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.k3_ph">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">k3_pts</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.k3_pts">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">k4_pr</label>
                                    <input type="number" class="form-control" id="class_name_add" v-model="addReportCard.k4_pr">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">status</label>
                                    <input type="text" class="form-control" id="class_name_add" v-model="addReportCard.status">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="class_name_add">predicate</label>
                                    <input type="text" class="form-control" id="class_name_add" v-model="addReportCard.predicate">
                                </div> 
                            </div>
                            
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
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" class="form-control" id="user_id" v-model="editSchool.user_id">
                        </div>
                        <div class="form-group">
                            <label for="class_name">Name School</label>
                            <input type="text" class="form-control" id="class_name" v-model="editSchool.name">
                        </div>
                         <div class="form-group">
                            <label for="type">Type School</label>
                            <select class="custom-select" id="type" v-model="editSchool.type">
                                <option value="elementary_school">Elementary School</option>
                                <option value="junior_high_school">Junior High School</option>
                                <option value="senior_high_school">Senior High School</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" placeholder="Description..." v-model="editSchool.description"></textarea>
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
document.title = 'Manage Report Card';

import Swal from 'sweetalert2';

export default {
    data() {
        return {
            /*table data*/
            TableSchool: [],
            PaginateSchool: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            school : [],
            /*data for add school*/
            addReportCard : {
            	sc_home_room_teacher_id : '',
            	sc_student_id : '',
            	type : '',
                description : '',
                period : '',
                absent_broken : '',
                absent_permission : '',
                absent_without_explanation : '',
                personality_behavior : '',
                personality_diligence : '',
                personality_neatness : '',
                sc_study_id : '',
                score : '',
                kkm_k3 : '',
                kkm_k4 : '',
                k3_ph : '',
                k3_pts : '',
                k4_pr : '',
                status : '',
                predicate : '',
                period : '',
                sc_study_id : ''
            },
            /*data for edit school*/
            editSchool: {
                id: '',
                user_id : '',
            	name : '',
            	description : '',
                type : ''
            }
        }
    },
    created() {
        /*call function default data for table*/
        this.appSchool();
        this.dataSchool();
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
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/school?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
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
                    url: '/api/school?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
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
                    url: '/api/school?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
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
                    url: '/api/school?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
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
                    url: '/api/school?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
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
                    url: '/api/school?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
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
                    url: '/api/school?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
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
                    url: '/api/school?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
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
        async dataSchool() {
            await axios({
                url : '/api/school/' + this.$store.state.Users.user.sc_school_id,
                method : 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                console.log(result.data);
                this.school = result.data;
                result.data.forEach(function(val, key){
                    if(val.type == 'senior_high_school'){
                        document.getElementById('senior_high_school').style.display = 'block';
                    }
                });
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*save data for add modal*/
        async createSave() {
        	await axios({
        		url : '/api/report-card',
        		method : 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
        		data : {
                    sc_home_room_teacher_id : this.addReportCard.sc_home_room_teacher_id,
                    sc_student_id : this.addReportCard.sc_student_id,
                    type : this.addReportCard.type,
                    description : this.addReportCard.description,
                    period : this.addReportCard.period,
                    absent_broken : this.addReportCard.absent_broken,
                    absent_permission : this.addReportCard.absent_permission,
                    absent_without_explanation : this.addReportCard.absent_without_explanation,
                    personality_behavior : this.addReportCard.personality_behavior,
                    personality_diligence : this.addReportCard.personality_diligence,
                    personality_neatness : this.addReportCard.personality_neatness,
                    sc_study_id : this.addReportCard.sc_study_id,
                    score : this.addReportCard.score,
                    kkm_k3 : this.addReportCard.kkm_k3,
                    kkm_k4 : this.addReportCard.kkm_k4,
                    k3_ph : this.addReportCard.k3_ph,
                    k3_pts : this.addReportCard.k3_pts,
                    k4_pr : this.addReportCard.k4_pr,
                    status : this.addReportCard.status,
                    predicate : this.addReportCard.predicate,
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
                url: '/api/school/' + this.editSchool.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                	user_id : this.editSchool.user_id,
                    name: this.editSchool.name,
                    description: this.editSchool.description,
                    type: this.editSchool.type
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
                url: '/api/school/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editSchool.id = val.id;
                    this.editSchool.user_id = val.user_id;
                    this.editSchool.name = val.name;
                    this.editSchool.description = val.description;
                    this.editSchool.type = val.type;
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
                        url: '/api/school/' + data,
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
