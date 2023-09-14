@extends('layouts.app')

@section('style')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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
                        <div class="col-md-12">
                            <div class="card mx-2 my-5">
                                <div class="card-header border-0">
                                    <i class="fas fa-filter"></i> Search Filter
                                </div>
                                <form method="post" action="{{ route('dashboard.reports.subassets.excel') }}" id="reportForm">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 area">
                                                <div class="form-group">
                                                    <label for="area_id">Area<span class="text-danger">*</span></label>
                                                    <select class="form-control select2" id="area_id" name="area_id">
                                                        @foreach($uses as $use)
                                                            <optgroup label="{{ $use->name }}">
                                                                @foreach($use->areas as $area)
                                                                    <option value="{{ $area->id }}" title="{{ $area->name }}">{{ $area->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="type">Status<span class="text-danger">*</span></label>
                                                    <select class="form-control select2" id="type" name="type">
                                                        <option value="allocated" title="Allocated">Allocated</option>
                                                        <option value="unallocated" title="Unallocated">Unallocated</option>
                                                    </select>

                                                </div>
                                            </div>

                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                            <button id="searchBtn" class="btn btn-primary">
                                                Search
                                            </button>
                                            <button id="excelReport" type="submit" class="btn btn-primary">
                                                Export To Excel
                                            </button>
                                        </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="defautlTable" class="table table-bordered table-striped nowrap" style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Land Category</th>
                                        <th>Area</th>
                                        <th>Hectares</th>
                                        <th>Acres</th>
                                        <th>Survey No</th>
                                        <th>Title No</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th id="tot"></th>
                                        <th></th>
                                        <th id="hec"></th>
                                        <th id="ac"></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </tfoot>

                                </table>
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
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $('document').ready(function () {
            var sumac = 0;
            var sumhec = 0;
            var num = 0;

            $("#defautlTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "processing": true,
                "serverSide": true,
                "searching": false,
                "paging": false,
                "ajax": {
                    'url':'{{route('dashboard.reports.subassets.index')}}',
                    'data': function(data){

                        var type = $('#type').val();
                        var area = $('#area_id').val();
                        // Append to data
                        data.type = type;
                        data.area = area;

                    }
                },
                "rowCallback": function( row, data, index ) {

                    sumac += parseFloat(data.acres);
                    sumhec += parseFloat(data.hectares);
                    num += 1;

                    $("#ac").html("Total Acres " + +(Math.round(sumac + "e+2")  + "e-2"));
                    $("#hec").html("Total Hectares " + +(Math.round(sumhec + "e+2")  + "e-2"));
                    $("#tot").html("Total Parcels " + num);
                },
                "columns": [
                    { data: 'uses' },
                    { data: 'area' },
                    { data: 'hectares' },
                    { data: 'acres' },
                    { data: 'survey_no' },
                    { data: 'parcel_no' },
                ],
            }).buttons().container().appendTo('#defautlTable_wrapper .col-md-6:eq(0)');
            $("#searchBtn").click(function(e){
                e.preventDefault();
                sumac = 0;
                sumhec = 0;
                num = 0;
                $("#ac").html("");
                $("#defautlTable").DataTable().draw();
            });
        });

    </script>
@endsection
