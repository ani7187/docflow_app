@extends('layouts.main')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3>Վիճակագրական տվյալներ</h3>
{{--            <h3 class="page-title">--}}
{{--                <span class="page-title-icon bg-gradient-primary text-white me-2">--}}
{{--                  <i class="mdi mdi-home"></i>--}}
{{--                </span> Dashboard--}}
{{--            </h3>--}}
{{--            <nav aria-label="breadcrumb">--}}
{{--                <ul class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item active" aria-current="page">--}}
{{--                        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </nav>--}}
        </div>
        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Հաստատված ֆայլեր <br>{{$startDate->format('Y-m-d')}} - {{now()->format('Y-m-d')}}<i class="mdi mdi-grease-pencil btn-icon-prepend mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{$signedCount}}</h2>
{{--                        <h6 class="card-text">Increased by 60%</h6>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-warning card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Ընթացիկ փաստաթղթեր <br>{{$startDate->format('Y-m-d')}} - {{now()->format('Y-m-d')}} <i class="mdi mdi-backup-restore mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{$currentCount}}</h2>
{{--                        <h6 class="card-text">Decreased by 10%</h6>--}}
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Ավարտված փաստաթղթեր <br>{{$startDate->format('Y-m-d')}} - {{now()->format('Y-m-d')}}<i class="mdi mdi-check-all mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-5">{{$finishCount}}</h2>
{{--                        <h6 class="card-text">Increased by 5%</h6>--}}
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-left">Visit And Sales Statistics</h4>
                            <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>
                        </div>
                        <canvas id="visit-sale-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Traffic Sources</h4>
                        <canvas id="traffic-chart"></canvas>
                        <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
            <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
        </div>
    </footer>
    <!-- partial -->
</div>
@endsection
