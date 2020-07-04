<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Manage Data Report Card</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">Report-Card</li>
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
                                    <a class="dropdown-item" :href="'/api/report-card/excel/export/' + user_id" download>Export Excel</a>
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
                                            <th>Teacher Id</th>
                                            <th>Student</th>
                                            <th>Study</th>
                                            <th>Score</th>
                                            <th>Status</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-for="data in TableReportCard">
                                        <tr>
                                            <td>{{data.id}}</td>
                                            <td>{{data.home_room_teacher_id}}</td>
                                            <td>{{data.student_name}}</td>
                                            <td>{{data.study_name}}</td>
                                            <td>{{data.score}}</td>
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
                                <pagination v-if="loading == false" :data="PaginateSchool" @pagination-change-page="appSchool"></pagination>
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
                                <label for="home_room_teacher_id">Homeroom Teacher ID</label>
                                <input type="text" class="form-control" id="home_room_teacher_id" v-model="addReportCard.sc_home_room_teacher_id">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="students_add">Student ID</label>
                                <input type="text" class="form-control" id="students_add" v-model="addReportCard.sc_student_id">
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
                                <label for="absent_add">Absent</label>
                                <input type="number" class="form-control" id="absent_add" v-model="addReportCard.absent_broken">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="absent_permision_add">Absent Permission</label>
                                <input type="number" class="form-control" id="absent_permision_add" v-model="addReportCard.absent_permission">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="absen_without_explanation_add">Absent Without Explanation</label>
                                <input type="number" class="form-control" id="absen_without_explanation_add" v-model="addReportCard.absent_without_explanation">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personality_behavior_add">Personality Behavior</label>
                                <input type="number" class="form-control" id="personality_behavior_add" v-model="addReportCard.personality_behavior">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personality_diligence_add">Personality Diligence</label>
                                <input type="number" class="form-control" id="personality_diligence_add" v-model="addReportCard.personality_diligence">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personlity_neatness_add">Personality Neatness</label>
                                <input type="number" class="form-control" id="personlity_neatness_add" v-model="addReportCard.personality_neatness">
                            </div>

                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personality_neatness_add">Personality Neatness</label>
                                <input type="date" class="form-control" id="personality_neatness_add" v-model="addReportCard.period">
                            </div>
                            
                        </div>
                        <div class="float-left">
                            <h5 class="card-title">Senior High School</h5>
                            <div class="dropdown-divider"></div>
                            <!-- senior -->
                            <div id="add_senior_high_school">
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="student_id_add">Student ID</label>
                                    <input type="number" class="form-control" id="student_id_add" v-model="addReportCard.sc_student_id">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="study_id_add">Study ID</label>
                                    <input type="number" class="form-control" id="study_id_add" v-model="addReportCard.sc_study_id">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="score_add">Score</label>
                                    <input type="number" class="form-control" id="score_add" v-model="addReportCard.score">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="kkm_k3_add">KKM K3</label>
                                    <input type="number" class="form-control" id="kkm_k3_add" v-model="addReportCard.kkm_k3">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="kkm_k4_add">KKM k4</label>
                                    <input type="number" class="form-control" id="kkm_k4_add" v-model="addReportCard.kkm_k4">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="k3_ph_add">K3 PH</label>
                                    <input type="number" class="form-control" id="k3_ph_add" v-model="addReportCard.k3_ph">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="k3_pts_add">K3 PTS</label>
                                    <input type="number" class="form-control" id="k3_pts_add" v-model="addReportCard.k3_pts">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="k4_praktek_add">K4 Praktek</label>
                                    <input type="number" class="form-control" id="k4_praktek_add" v-model="addReportCard.k4_pr">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="status_add">Status</label>
                                    <input type="text" class="form-control" id="status_add" v-model="addReportCard.status">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="predicate_add">Predicate</label>
                                    <select class="custom-select" id="predicate_add" v-model="addReportCard.predicate">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
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
                        <div class="float-left">
                            <h5 class="card-title">Information</h5>
                            <div class="dropdown-divider"></div>
                            <!-- type -->
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="user_id">Homeroom Teacher ID</label>
                                <input type="text" class="form-control" id="user_id" v-model="editReportCard.sc_home_room_teacher_id">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="student_id">Student ID</label>
                                <input type="text" class="form-control" id="student_id" v-model="editReportCard.sc_student_id">
                            </div>
                            <div class="form-group col-12 float-left">
                                <label for="type">Type School</label>
                                <select class="custom-select" id="type" v-model="editReportCard.type">
                                    <option value="odd_semester_1">Semester 1 Ganjil</option>
                                    <option value="even_semester_1">Semester 1 Genap</option>
                                    <option value="odd_semester_2">Semester 2 Ganjil</option>
                                    <option value="even_semester_2">Semester 2 Genap</option>
                                </select>
                            </div>
                            <div class="form-group col-12 float-left">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" placeholder="Description..." v-model="editReportCard.description"></textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="abosent">Absent</label>
                                <input type="number" class="form-control" id="abosent" v-model="editReportCard.absent_broken">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="absent_permission">Absent Permission</label>
                                <input type="number" class="form-control" id="absent_permission" v-model="editReportCard.absent_permission">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="absent_without_explanation">Absent Without Explanation</label>
                                <input type="number" class="form-control" id="absent_without_explanation" v-model="editReportCard.absent_without_explanation">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personality_behavior">Personality Behavior</label>
                                <input type="number" class="form-control" id="personality_behavior" v-model="editReportCard.personality_behavior">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personality_diligence">Personality Diligence</label>
                                <input type="number" class="form-control" id="personality_diligence" v-model="editReportCard.personality_diligence">
                            </div>
                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="personality_neatness">Personality Neatness</label>
                                <input type="number" class="form-control" id="personality_neatness" v-model="editReportCard.personality_neatness">
                            </div>

                            <div class="form-group col-sm-12 col-md-6 float-left">
                                <label for="period">Period</label>
                                <input type="date" class="form-control" id="period" v-model="editReportCard.period">
                            </div>
                            
                        </div>
                        <div class="float-left">
                            <h5 class="card-title">Senior High School</h5>
                            <div class="dropdown-divider"></div>
                            <!-- senior -->
                            <div id="add_senior_high_school">
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="student_id">Student ID</label>
                                    <input type="number" class="form-control" id="student_id" v-model="editReportCard.sc_student_id">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="study_id">Study ID</label>
                                    <input type="number" class="form-control" id="study_id" v-model="editReportCard.sc_study_id">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="score">Score</label>
                                    <input type="number" class="form-control" id="score" v-model="editReportCard.score">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="kkm_k3">KKM K3</label>
                                    <input type="number" class="form-control" id="kkm_k3" v-model="editReportCard.kkm_k3">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="kkm_k4">KKM k4</label>
                                    <input type="number" class="form-control" id="kkm_k4" v-model="editReportCard.kkm_k4">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="k3_ph">K3 PH</label>
                                    <input type="number" class="form-control" id="k3_ph" v-model="editReportCard.k3_ph">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="k3_pts">K3 PTS</label>
                                    <input type="number" class="form-control" id="k3_pts" v-model="editReportCard.k3_pts">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="k4_praktek">K4 Praktek</label>
                                    <input type="number" class="form-control" id="k4_praktek" v-model="editReportCard.k4_pr">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" id="status" v-model="editReportCard.status">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 float-left">
                                    <label for="predicate">Predicate</label>
                                    <select class="custom-select" id="predicate" v-model="editReportCard.predicate">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div> 
                            </div>
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
        document.title = 'Manage Report Card';
    },
    data() {
        return {
            user_id : this.$store.state.Users.user.id,
            /*table data*/
            TableReportCard: [],
            PaginateSchool: {},
            table: {
                columns: '25',
                orderable: 'id asc',
                searching: '',
            },
            school : [],
            /*data for add school*/
            addReportCard : {
                id : '',
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
            editReportCard: {
                id: '',
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
            loading : false
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
            this.loading = true;
            /*search ''*/
            if (data == '') {
                await axios({
                    url: '/api/report-card?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/report-card?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
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
                    url: '/api/report-card?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/report-card?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
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
                    url: '/api/report-card?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/report-card?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
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
                    url: '/api/report-card?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
                    this.PaginateSchool = result.data;
                    this.loading = false;
                }).catch(error => {
                    this.Error(error, error.message);
                });
                /*searching*/
            } else {
                await axios({
                    url: '/api/report-card?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=' + data,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableReportCard = result.data.data;
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
                this.school = result.data;
                result.data.forEach(function(val, key){
                    if(val.type == 'add_senior_high_school'){
                        document.getElementById('add_senior_high_school').style.display = 'block';
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
                url: '/api/report-card/' + this.editReportCard.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                    sc_home_room_teacher_id : this.editReportCard.sc_home_room_teacher_id,
                    sc_student_id : this.editReportCard.sc_student_id,
                    type : this.editReportCard.type,
                    description : this.editReportCard.description,
                    period : this.editReportCard.period,
                    absent_broken : this.editReportCard.absent_broken,
                    absent_permission : this.editReportCard.absent_permission,
                    absent_without_explanation : this.editReportCard.absent_without_explanation,
                    personality_behavior : this.editReportCard.personality_behavior,
                    personality_diligence : this.editReportCard.personality_diligence,
                    personality_neatness : this.editReportCard.personality_neatness,
                    sc_study_id : this.editReportCard.sc_study_id,
                    score : this.editReportCard.score,
                    kkm_k3 : this.editReportCard.kkm_k3,
                    kkm_k4 : this.editReportCard.kkm_k4,
                    k3_ph : this.editReportCard.k3_ph,
                    k3_pts : this.editReportCard.k3_pts,
                    k4_pr : this.editReportCard.k4_pr,
                    status : this.editReportCard.status,
                    predicate : this.editReportCard.predicate,
                }
            }).then(result => {
                $('#modal-1').modal('hide');
                this.RequestSuccess(result.data.message);
                /*refresh*/
                this.appSchool();
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*edit/get data on click for table*/
        async editRequest(id) {
            await axios({
                url: '/api/report-card/' + id,
                method: 'get',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                $('#modal-1').modal('show');
                result.data.forEach((val, key) => {
                    this.editReportCard.id = val.id;
                    this.editReportCard.sc_home_room_teacher_id = val.sc_home_room_teacher_id;
                    this.editReportCard.sc_student_id = val.sc_student_id;
                    this.editReportCard.type = val.type;
                    this.editReportCard.description = val.description;
                    this.editReportCard.period = val.period;
                    this.editReportCard.absent_broken = val.absent_broken;
                    this.editReportCard.absent_permission = val.absent_permission;
                    this.editReportCard.absent_without_explanation = val.absent_without_explanation;
                    this.editReportCard.personality_behavior = val.personality_behavior;
                    this.editReportCard.personality_diligence = val.personality_diligence;
                    this.editReportCard.personality_neatness = val.personality_neatness;
                    this.editReportCard.sc_study_id = val.sc_study_id;
                    this.editReportCard.score = val.score;
                    this.editReportCard.kkm_k3 = val.kkm_k3;
                    this.editReportCard.kkm_k4 = val.kkm_k4;
                    this.editReportCard.k3_ph = val.k3_ph;
                    this.editReportCard.k3_pts = val.k3_pts;
                    this.editReportCard.k4_pr = val.k4_pr;
                    this.editReportCard.status = val.status;
                    this.editReportCard.predicate = val.predicate;
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
                        url: '/api/report-card/' + data,
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
