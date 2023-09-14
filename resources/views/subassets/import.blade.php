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
                                <div class="col-md-2">
                                    <i class="fa fa-file-import"></i> Import {{ $title }}
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <h3>Instructions</h3>
                            Click the download button to download the sample. <br>
                            Make sure that your file is UTF-8 to avoid unnecessary encoding problems. <br>
                            You can import sub assets only based on parent asset ,land use, and area. <br>
                            To add assets go to assets on the left side menu and click List Assets. <a href="{{ route('dashboard.assets.index') }}">Take Me To Assets</a> <br>
                            To add land use go to settings and click Land Use. <a href="{{ route('dashboard.uses.index') }}">Take Me To Land Use</a> <br>
                            To add areas go to settings and click Areas. <a href="{{ route('dashboard.areas.index') }}">Take Me To Areas</a> <br>

                            <a href="{{ route('dashboard.subassets.import.download.sample') }}" class="btn btn-primary mt-2">Download Sample</a>

                            <form method="post" action="{{ route('dashboard.subassets.import.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="asset_use_id">Land Category<span class="text-danger">*</span></label>
                                            <select class="form-control select2" id="asset_use_id" name="asset_use_id">
                                                @foreach($uses as $use)
                                                    <option value="{{ $use->id }}" title="{{ $use->name }}">{{ $use->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="area_id">Area<span class="text-danger">*</span></label>
                                            <select class="form-control select2" id="area_id" name="area_id">
                                                @foreach($areas as $area)
                                                    <option value="{{ $area->id }}" title="{{ $area->name }}">{{ $area->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="importFile">File<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input name="importFile" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="custom-file-input" id="exampleInputFile" required>
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="input-group" style="margin-top: 30px">
                                            <button type="submit" class="btn btn-primary">Import</button>
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

@endsection
