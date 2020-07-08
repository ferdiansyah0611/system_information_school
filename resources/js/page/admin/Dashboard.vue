<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Dashboard</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Welcome to web system information</li>
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
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-import">Import User</a>
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
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h5>Welcome Back !</h5>
                                        <p class="text-muted">{{user.name}}</p>
                                        <div class="mt-4">
                                            <a href="#" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-5 ml-auto">
                                        <div>
                                            <img src="/vendor/template/images/widget-img.png" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4 text-center">Date Now</h5>
                                <h3 class="text-center font-weight-bold">{{dateNow}}</h3>
                                <h3 class="text-center font-weight-bold" id="time"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">Statistic School & Student</h5>
                                <canvas id="lineChart" class="apex-charts"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">Profile</h5>
                                <div class="text-center">
                                    <img :src="'/storage/image/' + user.avatar" alt="Avatar Profile" width="100%" class="rounded-circle">
                                </div>
                                <div class="col-4 float-left mt-3">
                                    <p>Name</p>
                                    <p>NISN</p>
                                    <p>Location</p>
                                </div>
                                <div class="col-8 float-left mt-3">
                                    <p>: {{user.name}}</p>
                                    <p>: {{user.nisn}}</p>
                                    <p>: {{user.location}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">Latest User</h5>
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
                                                <th>Name</th>
                                                <th>NISN</th>
                                                <th>Updated On</th>
                                            </tr>
                                        </thead>
                                        <tbody v-for="data in TableUser">
                                            <tr>
                                                <td>{{data.id}}</td>
                                                <td>{{data.name}}</td>
                                                <td>{{data.nisn}}</td>
                                                <th>{{data.updated_at}}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
import Chart from 'chart.js';
export default {
    beforeMount() {
        document.title = 'Dashboard';
    },
    data() {
        return {
            user : this.$store.state.Users.user,
            dateNow : new Date().getDate() + '/' + new Date().getMonth() + '/' + new Date().getFullYear(),
            imports : '',
            TableUser: [],
            loading : false
        }
    },
    mounted() {
        $(function(){
            axios({
                url : '/api/dashboard',
                method : 'get',
                headers : {
                    'Authorization' : 'Bearer ' + JSON.parse(window.localStorage.getItem('users')).success.token
                }
            }).then(result => {
                var e = $("#lineChart").get(0).getContext("2d");
                new Chart(e, {
                    type: "line",
                    data: {
                        labels: [
                        (new Date().getFullYear() ).toString(),
                        (new Date().getFullYear() + 1).toString(),
                        (new Date().getFullYear() + 2).toString(), 
                        (new Date().getFullYear() + 3).toString(), 
                        (new Date().getFullYear() + 4).toString(), 
                        (new Date().getFullYear() + 5).toString(), 
                        (new Date().getFullYear() + 6).toString(), 
                        (new Date().getFullYear() + 7).toString()], 
                        datasets: [
                            { label: "School", data: [
                                result.data.school.year_2020, 
                                result.data.school.year_2021,
                                result.data.school.year_2022,
                                result.data.school.year_2023,
                                result.data.school.year_2024,
                                result.data.school.year_2025,
                                result.data.school.year_2026, 
                                result.data.school.year_2027
                            ], borderColor: ["#3ddc97"], borderWidth: 3, fill: !1, pointBackgroundColor: "#ffffff", pointBorderColor: "#3ddc97" },
                            { label: "Student", data: [
                                result.data.student.year_2020, 
                                result.data.student.year_2021,
                                result.data.student.year_2022,
                                result.data.student.year_2023,
                                result.data.student.year_2024,
                                result.data.student.year_2025,
                                result.data.student.year_2026, 
                                result.data.student.year_2027
                            ], borderColor: ["#7c8a96"], borderWidth: 3, fill: !1, pointBackgroundColor: "#ffffff", pointBorderColor: "#7c8a96" },
                        ],
                    },
                    options: {
                        scales: { yAxes: [{ gridLines: { drawBorder: !1, borderDash: [3, 3], zeroLineColor: "#7b919e" }, ticks: { min: 0, color: "#7b919e" } }], xAxes: [{ gridLines: { display: !1, drawBorder: !1, color: "#ffffff" } }] },
                        elements: { line: { tension: 0.2 }, point: { radius: 4 } },
                        stepsize: 1,
                    },
                });

            })
        });
    },
    created() {
        this.appClass();
        this.time();
    },
    methods: {
        time() {
            setInterval(function(){
                document.getElementById('time').innerText = new Date().getHours() + ':' + new Date().getMinutes() + ':' + new Date().getSeconds();
            }, 1000);
        },
        async appClass(paginate = 1) {
            this.loading = true;
            await axios({
                    url: '/api/users?page=' + paginate,
                    method: 'get',
                    headers : {
                        'Authorization' : 'Bearer ' + this.$store.state.Users.success.token
                    },
                }).then(result => {
                    this.TableUser = result.data.data;
                    this.loading = false;
                }).catch(error => {
                    this.serverErrorPage(error, error.message);
                });
        },
        async importData() {
            var formData = new FormData();
            formData.append('import', this.imports);
            await axios({
                url : '/api/class/excel/import/' + this.user.id,
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
