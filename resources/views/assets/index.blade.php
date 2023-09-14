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
                    <div class="card-header">
                       <div class="row">
                           <div class="col-md-12">
                               <div class="form-group">
                                   @can('assets:create')
                                       <a class="btn btn-primary" href="{{ route('dashboard.assets.create') }}"><i class="fa fa-plus-circle"></i> Add {{ $title }}</a>
                                   @endcan
                                   @can('assets:import')
                                       <a class="btn btn-primary" href="{{ route('dashboard.assets.import') }}"><i class="fa fa-file-import"></i> Import {{ $title }}</a>
                                   @endcan
                                   @can('assets:export')
                                       <a class="btn btn-primary" href="{{ route('dashboard.assets.export') }}"><i class="fa fa-file-export"></i> Export {{ $title }}</a>
                                   @endcan
                               </div>
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
                                    <th>Name</th>
                                    <th>Hectares</th>
                                    <th>Acres</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assets as $asset)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $asset->name }}</td>
                                        <td>{{ round($asset->total_acres/2.4710538146717,2) }}</td>
                                        <td>{{ $asset->total_acres }}</td>
                                        <td>
                                            @can('assets:update')
                                                <a href="{{ route('dashboard.assets.edit', $asset->id) }}" class="btn btn-info btn-sm"><i class="fa fa-pen"></i></a>
                                            @endcan
                                            @can('assets:delete')
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" data-id="{{ $asset->id }}" data-name="{{ $asset->name }}"><i class="fa fa-trash"></i></button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Acres</th>
                                    <th>Hectares</th>
                                    <th>Action</th>
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
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('dashboard.assets.delete') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete?</p>
                    <input type="hidden" name="id" value="">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
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
            $('#modal-delete').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name = button.data('name')
                var modal = $(this)
                modal.find('.modal-title').text('Delete Group Ranch '+ name)
                modal.find('.modal-body input').val(id)
            })
        });

    </script>
@endsection
