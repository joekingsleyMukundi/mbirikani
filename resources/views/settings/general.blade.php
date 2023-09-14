@extends('layouts.app_settings')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="col-12 mt-3">
            <div class="card">

                <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.settings.general.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="name">Business Name<span class="text-danger">*</span></label>
                            <input autofocus type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $settings->business_name }}" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="name">Business Phone<span class="text-danger">*</span></label>
                            <input autofocus type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ $settings->business_phone }}" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="name">Business Email<span class="text-danger">*</span></label>
                            <input autofocus type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ $settings->business_email }}" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="name">Business Location<span class="text-danger">*</span></label>
                            <input autofocus type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{ $settings->business_location }}" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input autofocus type="file" class="form-control-file" id="logo" name="logo" value="">

                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('dashboard.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                            <div class="col d-flex justify-content-end align-content-end">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.card -->
        </div>

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

@endsection
