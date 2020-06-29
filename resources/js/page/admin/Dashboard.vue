<template>
    <div>
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title mb-1">Dashboard</h4>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Welcome to web system information <b>By Ferdiansyah</b></li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <div class="float-right d-none d-md-block">
                            <div class="dropdown">
                                <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-settings-outline mr-1"></i> Settings
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Separated link</a>
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
                                        <p class="text-muted">{{username}}</p>
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
                                <h5 class="header-title mb-4">Monthy sale Report</h5>
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted mb-2">This month Sale</p>
                                        <h4>$ 13,425</h4>
                                    </div>
                                    <div dir="ltr" class="ml-2">
                                        <input data-plugin="knob" data-width="56" data-height="56" data-linecap=round data-displayInput=false data-fgColor="#3051d3" value="56" data-skin="tron" data-angleOffset="56" data-readOnly=true data-thickness=".17" />
                                    </div>
                                </div>
                                <hr>
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted">Sale status</p>
                                        <h5 class="mb-0"> + 12 % <span class="font-size-14 text-muted ml-1">From previous period</span></h5>
                                    </div>
                                    <div class="align-self-end ml-2">
                                        <a href="#" class="btn btn-primary btn-sm">View more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-inline float-right">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm datepicker-here" data-range="true" data-multiple-dates-separator=" - " data-language="en" placeholder="Select Date" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="far fa-calendar font-size-12"></i></span>
                                        </div>
                                    </div>
                                </form>
                                <h5 class="header-title mb-4">Sales Report</h5>
                                <canvas id="lineChart" class="apex-charts"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-transparent p-3">
                                <h5 class="header-title mb-0">Sales Status</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">Number of Sales</p>
                                            <h5 class="mb-0">1,625</h5>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-layer-group"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">Sales Revenue </p>
                                            <h5 class="mb-0">$ 42,235</h5>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-analytics"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">Average Price</p>
                                            <h5 class="mb-0">$ 14.56</h5>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-ruler"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="media my-2">
                                        <div class="media-body">
                                            <p class="text-muted mb-2">Product Sold</p>
                                            <h5 class="mb-0">8,235</h5>
                                        </div>
                                        <div class="icons-lg ml-2 align-self-center">
                                            <i class="uim uim-box"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mb-4">Social Source</h5>
                                <div id="radial-chart" class="apex-charts"></div>
                                <div class="text-center mt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted"><i class="mdi mdi-circle text-primary mr-1"></i> Facebook</p>
                                                <h5>$ 1,625</h5>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <p class="text-muted"><i class="mdi mdi-circle text-warning mr-1"></i> Twitter</p>
                                                <h5>$ 1,504</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title">Recent Activity</h5>
                                <div id="activity-chart" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
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
            username : this.$store.state.Users.user.name
        }
    },
    mounted() {
        $(function(){
            var e = $("#lineChart").get(0).getContext("2d");
            new Chart(e, {
                type: "line",
                data: {
                    labels: ["2020", "2021", "2022", "2023", "2024", "2025", "2026", "2027"],
                    datasets: [
                        { label: "Apple", data: [120, 180, 140, 210, 160, 240, 180, 210], borderColor: ["#3ddc97"], borderWidth: 3, fill: !1, pointBackgroundColor: "#ffffff", pointBorderColor: "#3ddc97" },
                        { label: "Samsung", data: [80, 140, 100, 170, 120, 200, 140, 170], borderColor: ["#7c8a96"], borderWidth: 3, fill: !1, pointBackgroundColor: "#ffffff", pointBorderColor: "#7c8a96" },
                    ],
                },
                options: {
                    scales: { yAxes: [{ gridLines: { drawBorder: !1, borderDash: [3, 3], zeroLineColor: "#7b919e" }, ticks: { min: 0, color: "#7b919e" } }], xAxes: [{ gridLines: { display: !1, drawBorder: !1, color: "#ffffff" } }] },
                    elements: { line: { tension: 0.2 }, point: { radius: 4 } },
                    stepsize: 1,
                },
            });
        });
    },
    created() {

    },
    methods: {

    }
}

</script>
