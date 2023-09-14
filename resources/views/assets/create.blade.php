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
                        <li class="breadcrumb-item active">Add</li>
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

                        <form method="post" action="{{ route('dashboard.assets.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="total_acres">Acres<span class="text-danger">*</span></label>
                                        <input autofocus type="number" class="form-control" id="total_acres" name="total_acres" placeholder="Total Acres" step="any" value="" required maxlength="255">
                                    </div>
                                </div>


                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('dashboard.assets.index') }}" class="btn btn-danger">Cancel</a>
                                    </div>
                                    <div class="col d-flex justify-content-end align-content-end">
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                </div>
                            </div>
                        </form>

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
