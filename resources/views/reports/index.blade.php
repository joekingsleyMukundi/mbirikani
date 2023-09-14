@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Allocation Report</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row col-md-12">
                                    
                                        @foreach($catPieCharts as $catPieChart)
                                            <div class="col-md-6">
                                                <div class="card mx-1">
                                                    <div class="card-header border-0">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="card-title">{{$catPieChart['name']}}</h3>
                                                            @can('allocations:list')
                                                                <a href="{{ route('dashboard.allocations.index') }}">View Allocations</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="catpieChart{{$catPieChart['id']}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                    </div>

                                                </div>
                                            </div>

                                        @endforeach
                                        
                                        @foreach($pieCharts as $pieChart)
                                            <div class="col-md-6">
                                                <div class="card mx-1">
                                                    <div class="card-header border-0">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="card-title">{{$pieChart['name']}}</h3>
                                                            @can('allocations:list')
                                                            <a href="{{ route('dashboard.allocations.index') }}">View Allocations</a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="pieChart{{$pieChart['id']}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                    </div>

                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            
                            </div>

                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Land Category Report</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row col-md-12">
                                        @foreach($barCharts as $barChart)
                                            <div class="col-md-12 ">
                                                <div class="card mx-1">
                                                    <div class="card-header border-0">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="card-title">{{$barChart['name']}}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="chart">
                                                            <canvas id="barChart{{$barChart['id']}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>

                            </div>




                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('script')


    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    <script>
        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */
            var barData = {!! json_encode($barCharts) !!};

            barData.forEach((element) => {

                var areaChartData = {
                    labels  : element.labels,
                    datasets: [
                        {
                            label               : 'Usage',
                            backgroundColor     : element.colors,
                            data                : element.data
                        },
                    ]
                }

                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart'+element.id).get(0).getContext('2d')
                var barChartData = $.extend(true, {}, areaChartData)

                var temp0 = areaChartData.datasets[0]

                barChartData.datasets[0] = temp0


                var barChartOptions = {
                    animation               : false,
                    parsing                 : false,
                    responsive              : true,
                    maintainAspectRatio     : false,
                    datasetFill             : true,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            gridLines : {
                                display : false,
                            },
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            },
                            gridLines : {
                                display : false,
                            }
                        }]
                    }
                }

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                })

            });



            var piechartData = {!! json_encode($pieCharts) !!};

            piechartData.forEach((element) => {

                var donutData        = {
                    labels: element.labels,
                    datasets: [
                        {
                            data: element.data,
                            backgroundColor : element.colors,
                        }
                    ]
                }
                var donutOptions     = {
                    parsing: false,
                    maintainAspectRatio : false,
                    responsive : true,
                    animation: false,
                }
                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $('#catpieChart'+element.id).get(0).getContext('2d')
                var pieData        = donutData;
                var pieOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                })
            });

            var catpiechartData = {!! json_encode($catPieCharts) !!};

            catpiechartData.forEach((element) => {

                var donutData        = {
                    labels: element.labels,
                    datasets: [
                        {
                            data: element.data,
                            backgroundColor : element.colors,
                        }
                    ]
                }
                var donutOptions     = {
                    parsing: false,
                    maintainAspectRatio : false,
                    responsive : true,
                    animation: false,
                }
                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $('#pieChart'+element.id).get(0).getContext('2d')
                var pieData        = donutData;
                var pieOptions     = {
                    maintainAspectRatio : false,
                    responsive : true,
                }
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                })
            });




        })
    </script>
@endsection
