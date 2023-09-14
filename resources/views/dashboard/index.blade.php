@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        .clicked{
            color: #e71a3d;
        }
    </style>
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            @can('dashboards:main')
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-fuchsia">
                            <div class="inner">
                                <h3>{{ count($members) }}</h3>

                                <p>Members</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('dashboard.members.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-olive">
                            <div class="inner">
                                <h3>{{ count($users) }}</h3>

                                <p>Staff</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users-crown"></i>
                            </div>
                            <a href="{{ route('dashboard.users.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-blue">
                            <div class="inner">
                                <h3>{{ count($assets) }}</h3>

                                <p>Group Ranches</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rectangle-wide"></i>
                            </div>
                            <a href="{{ route('dashboard.assets.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-blue">
                            <div class="inner">
                                <h3>{{ count($subassets) }}</h3>

                                <p>Parcels</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rectangles-mixed"></i>
                            </div>
                            <a href="{{ route('dashboard.subassets.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-yellow">
                            <div class="inner">
                                <h3>{{ count($areas) }}</h3>

                                <p>Areas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <a href="{{ route('dashboard.areas.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-maroon">
                            <div class="inner">
                                <h3>{{ count($uses) }}</h3>

                                <p>Land Categories</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-object-group"></i>
                            </div>
                            <a href="{{ route('dashboard.uses.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-gradient-orange">
                            <div class="inner">
                                <h3>{{ count($allocations) }}</h3>

                                <p>Allotments</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-rectangle-history-circle-user"></i>
                            </div>
                            <a href="{{ route('dashboard.allocations.index') }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endcan

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
@section('script')
    <script src="{{ asset('plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function () {
        })
    </script>
@endsection
