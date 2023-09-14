@extends('layouts.app')

@section('style')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
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
                        <li class="breadcrumb-item active">User</li>
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
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="card card-primary card-outline">
                                            <div class="card-body box-profile">
                                                <div class="text-center">
                                                    @if(isset(Auth::user()->pic))
                                                        <img src="{{ Auth::user()->pic }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                                                    @else
                                                        <i class="mt-2 fa fa-user fa-3x text-black"></i>
                                                    @endif
                                                </div>
                                                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Phone</b> <a class="float-right">{{ Auth::user()->phone }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-9">
                                        <div class="card card-primary">
                                            <div class="card-header p-2">
                                                <h3 class="card-title">Change Password</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content">

                                                    <div class="tab-pane active" id="password">
                                                        <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.users.password.store') }}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="current_password">Current Password<span class="text-danger">*</span></label>
                                                                        <input autofocus type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" value="" required maxlength="255">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="password">New Password<span class="text-danger">*</span></label>
                                                                        <input autofocus type="password" class="form-control" id="password" name="password" placeholder="New Password" value="" required maxlength="255">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="confirm_password">Confirm Password<span class="text-danger">*</span></label>
                                                                        <input autofocus type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value="" required maxlength="255">

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col">
                                                                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-danger">Cancel</a>
                                                                </div>
                                                                <div class="col d-flex justify-content-end align-content-end">
                                                                    <button type="submit" class="btn btn-success">Change</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>

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

@endsection
