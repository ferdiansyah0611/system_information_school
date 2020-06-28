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
                                <table class="table mb-0">
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
                                <pagination :data="PaginateStudent" @pagination-change-page="appSchool"></pagination>
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
                            <label for="user_id_add">User ID</label>
                            <input type="text" class="form-control" id="user_id_add" required v-model="addStudent.user_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="sc_school_id_add">School</label>
                            <select class="custom-select" id="sc_school_id_add" required v-model="addStudent.sc_school_id">
                                <option v-for="data in school" :key="data.id" :value="data.id">{{data.name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="sc_class_id_add">Class</label>
                            <input type="text" class="form-control" id="sc_class_id_add" required v-model="addStudent.sc_class_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone_add">Phone</label>
                            <input type="text" class="form-control" id="phone_add" required v-model="addStudent.phone">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="father_add">Father</label>
                            <input type="text" class="form-control" id="father_add" required v-model="addStudent.father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="mother_add">Mother</label>
                            <input type="text" class="form-control" id="mother_add" required v-model="addStudent.mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_work_father">Work Father</label>
                            <input type="text" class="form-control" id="add_work_father" required v-model="addStudent.work_father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="add_work_mother">Work Mother</label>
                            <input type="text" class="form-control" id="add_work_mother" required v-model="addStudent.work_mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone_father_add">Phone Father</label>
                            <input type="text" class="form-control" id="phone_father_add" required v-model="addStudent.phone_father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone_mother_add">Phone Mother</label>
                            <input type="text" class="form-control" id="phone_mother_add" required v-model="addStudent.phone_mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="generation_add">Generation</label>
                            <input type="text" class="form-control" id="generation_add" required v-model="addStudent.generation">
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
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="user_id">User ID</label>
                            <input type="text" class="form-control" id="user_id" required v-model="editStudent.user_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="sc_school_id">School</label>
                            <select class="custom-select" id="sc_school_id" required v-model="editStudent.sc_school_id">
                                <option v-for="data in school" :key="data.id" :value="data.id">{{data.name}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="sc_class_id">Class</label>
                            <input type="text" class="form-control" id="sc_class_id" required v-model="editStudent.sc_class_id">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" required v-model="editStudent.phone">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="nisn">NISN</label>
                            <input type="text" class="form-control" id="nisn" required v-model="editStudent.nisn">
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
                            <label for="work_father">Work Father</label>
                            <input type="text" class="form-control" id="work_father" required v-model="editStudent.work_father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="work_mother">Work Mother</label>
                            <input type="text" class="form-control" id="work_mother" required v-model="editStudent.work_mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone_father">Phone Father</label>
                            <input type="text" class="form-control" id="phone_father" required v-model="editStudent.phone_father">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="phone_mother">Phone Mother</label>
                            <input type="text" class="form-control" id="phone_mother" required v-model="editStudent.phone_mother">
                        </div>
                        <div class="form-group col-sm-12 col-md-6 float-left">
                            <label for="generation">Generation</label>
                            <input type="text" class="form-control" id="generation" required v-model="editStudent.generation">
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
document.title = 'Manage Student';

import Swal from 'sweetalert2';

export default {
    data() {
        return {
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
                phone: '',
                father: '',
                mother: '',
                work_father: '',
                work_mother: '',
                phone_father: '',
                phone_mother: '',
                generation: ''
            },
            /*data for edit student*/
            editStudent: {
                id: '',
                user_id: '',
                sc_school_id: '',
                sc_class_id: '',
                phone: '',
                father: '',
                mother: '',
                work_father: '',
                work_mother: '',
                phone_father: '',
                phone_mother: '',
                generation: ''
            }
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
        async serverErrorPage(error, message) {
            console.error(error);
            Swal.fire('Error!', message + '. Please wait for the page to resfresh automatically', 'error');
            setTimeout(function() {
                window.location.reload();
            }, 5000);
        },
        /*display error*/
        async Error(error, message) {
            console.error(error);
            Swal.fire('Error!', message, 'error');
        },
        /*display success*/
        async RequestSuccess(message) {
            Swal.fire('Success!', message, 'success');
            setTimeout(function() {
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
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
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
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
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
                    url: '/api/student?page=' + paginate + '&orderby=' + type[0] + '&type=' + type[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
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
                    url: '/api/student?page=' + paginate + '&orderby=' + order[0] + '&type=' + order[1] + '&columns=' + columns + '&search=default',
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    }
                }).then(result => {
                    this.TableStudent = result.data.data;
                    this.PaginateStudent = result.data;
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
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                }
            }).then(result => {
                this.school = result.data.data;
            }).catch(error => {
                this.Error(error, error.message);
            });
        },
        /*save data for add modal*/
        async createSave() {
            await axios({
                url: '/api/student',
                method: 'post',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                    user_id: this.addStudent.user_id,
                    sc_school_id: this.addStudent.sc_school_id,
                    sc_class_id: this.addStudent.sc_class_id,
                    phone: this.addStudent.phone,
                    father: this.addStudent.father,
                    mother: this.addStudent.mother,
                    work_father: this.addStudent.work_father,
                    work_mother: this.addStudent.work_mother,
                    phone_father: this.addStudent.phone_father,
                    phone_mother: this.addStudent.phone_mother,
                    generation: this.addStudent.generation,
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
                url: '/api/student/' + this.editStudent.id,
                method: 'put',
                headers : {
                    'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                },
                data: {
                    user_id: this.editStudent.user_id,
                    sc_school_id: this.editStudent.sc_school_id,
                    sc_class_id: this.editStudent.sc_class_id,
                    phone: this.editStudent.phone,
                    father: this.editStudent.father,
                    mother: this.editStudent.mother,
                    work_father: this.editStudent.work_father,
                    work_mother: this.editStudent.work_mother,
                    phone_father: this.editStudent.phone_father,
                    phone_mother: this.editStudent.phone_mother,
                    generation: this.editStudent.generation,
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
                    Swal.fire('Cancelled', 'Your data is safe', 'error')
                }
            });
        },
        /*change event in here...*/

    }
}

</script>