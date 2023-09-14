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

                        <form method="post" action="{{ route('dashboard.allocations.update', $subasset->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="subasset_id">Parcel<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="subasset_id" name="subasset_id">
                                            @foreach($subassets as $subasseta)
                                                <option value="{{ $subasseta->id }}" {{ $subasseta->id == $subasset->id ? "selected" : "" }} title="{{ $subasseta->survey_no }}">{{ $subasseta->survey_no }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="parcel_no">Title No<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="parcel_no" name="parcel_no" placeholder="Title No" value="{{ $subasset->parcel_no }}" required maxlength="255">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="member_ids">Member<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="member_id" name="member_id">
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ $member->id == $subasset->member_id ? "selected" : "" }} title="{{ $member->name }} {{ $member->id_no }}">{{ $member->name }} {{ $member->id_no }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('dashboard.allocations.index') }}" class="btn btn-danger">Cancel</a>
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
