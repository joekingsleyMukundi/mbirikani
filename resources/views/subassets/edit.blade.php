@extends('layouts.app')

@section('style')

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
                        <li class="breadcrumb-item active">Edit</li>
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

                        <form method="post" action="{{ route('dashboard.subassets.update', $subasset->id) }}">
                            @csrf
                            <div class="card-body">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="survey_no">Survey No<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="survey_no" name="survey_no" placeholder="Survey No" value="{{ $subasset->survey_no }}" required maxlength="255">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="parcel_no">Title No</label>
                                        <input autofocus type="text" class="form-control" id="parcel_no" name="parcel_no" placeholder="Title No" value="{{ $subasset->parcel_no }}" maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="acres">Acres<span class="text-danger">*</span></label>
                                        <input autofocus type="number" class="form-control" id="acres" name="acres" placeholder="Total Acres" step="any" value="{{ $subasset->acres }}" required maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="asset_id">Group Ranch<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="asset_id" name="asset_id">
                                            @foreach($assets as $asset)
                                                <option value="{{ $asset->id }}" {{ $asset->id == $subasset->asset_id ? "selected" : "" }} title="{{ $asset->name }}">{{ $asset->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="area_id">Area<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="area_id" name="area_id">
                                            @foreach($uses as $use)
                                                <optgroup label="{{ $use->name }}">
                                                    @foreach($use->areas as $area)
                                                        <option value="{{ $area->id }}" {{ $area->id == $subasset->area_id ? "selected" : "" }} title="{{ $area->name }}">{{ $area->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('dashboard.subassets.index') }}" class="btn btn-danger">Cancel</a>
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

@endsection
