@extends('layouts.app_settings')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-md-2">
                               <div class="form-group">
                                   @can('roles:create')
                                       <a class="btn btn-primary" href="{{ route('dashboard.settings.roles.create') }}"><i class="fa fa-plus-circle"></i> Add  {{ $secondarytitle }}</a>
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
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ ucfirst($role->name) }}</td>
                                        <td>
                                            @if(ucfirst($role->name) == "Super Admin")
                                                <span class="badge badge-success badge-pill">All</span>
                                            @else
                                                @foreach($role->permissions as $permission)
                                                    <span class="badge badge-success badge-pill">{{ $permission->description }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        @if(ucfirst($role->name) == "Super Admin")
                                            <td>

                                            </td>
                                        @else
                                            <td>
                                                @can('roles:update')
                                                    <a href="{{ route('dashboard.settings.roles.edit', $role->id) }}" class="btn btn-info btn-sm"><i class="fa fa-pen"></i></a>
                                                @endcan
                                                @can('roles:delete')
                                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-delete" data-id="{{ $role->id }}" data-name="{{ $role->name }}"><i class="fa fa-trash"></i></button>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
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
            <form method="post" action="{{ route('dashboard.settings.roles.delete') }}">
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
                modal.find('.modal-title').text('Delete Role ' + name)
                modal.find('.modal-body input').val(id)
            })
        });

    </script>
@endsection
