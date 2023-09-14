@extends('layouts.app_settings')

@section('style')
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">

                        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.settings.roles.update', $role->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ ucfirst($role->name) }}" required maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="permission_id">Permissions<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="permission_id" name="permissions[]">

                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}">{{ $permission->description }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('dashboard.settings.roles.index') }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                    <div class="col d-flex justify-content-end align-content-end">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script>
    var data = {!! $role->permissions->pluck('id') !!}
    $('#permission_id').select2(
        {
            multiple: true,
            allowClear: true,

        }
    );
    $('#permission_id').val(data);
    $('#permission_id').trigger('change');
</script>
@endsection
