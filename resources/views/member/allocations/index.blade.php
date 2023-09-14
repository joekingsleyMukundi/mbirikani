@extends('member.layouts.app')

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
                    <div class="card-header">
                       <div class="row">
                           <div class="col-md-2">

                           </div>
                       </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="defautlTable" class="table table-bordered table-striped nowrap" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group Ranch</th>
                                    <th>Survey No</th>
                                    <th>Title No</th>
                                    <th>Hectares</th>
                                    <th>Acres</th>
                                    <th>Area</th>
                                    <th>Land Category</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allocations as $allocation)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $allocation->asset->name }}</td>
                                        <td>{{ $allocation->survey_no }}</td>
                                        <td>{{ $allocation->parcel_no }}</td>
                                        <td>{{ round($allocation->acres/2.4710538146717,2) }}</td>
                                        <td>{{ round($allocation->acres)}}</td>
                                        <td>{{ $allocation->area->name }}</td>
                                        <td>{{ $allocation->area->uses->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Group Ranch</th>
                                    <th>Survey No</th>
                                    <th>Title No</th>
                                    <th>Hectares</th>
                                    <th>Acres</th>
                                    <th>Area</th>
                                    <th>Land Category</th>
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
    <script src="{{ asset('plugins/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script>
        $('document').ready(function () {
            $("#defautlTable").DataTable({
                "responsive": true,
                "lengthChange": false
            }).buttons().container().appendTo('#defautlTable_wrapper .col-md-6:eq(0)');
        });

    </script>
@endsection
