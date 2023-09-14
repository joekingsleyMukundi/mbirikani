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

                            <form method="post" enctype="multipart/form-data" action="{{ route('dashboard.members.store') }}">
                                @csrf

                                <div class="card-body">

                                    <div class="">
                                        <h5>Mandatory Fields</h5>
                                    </div>

                                    <div class="form-group">
                                        <label for="membership_number">Membership Number<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="membership_number" name="membership_number" placeholder="Membership Number" value="" required maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="first_name">First Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="" required maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="" required maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="dob">Date Of Birth<span class="text-danger">*</span></label>
                                        <input autofocus type="date" class="form-control" id="dob" name="dob" placeholder="Date Of Birth" value="" required maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="marital_status">Marital Status<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="marital_status" name="marital_status">
                                            <option value="married" title="Male">Married</option>
                                            <option value="single" title="Female">Single</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kra">KRA</label>
                                        <input autofocus type="text" class="form-control" id="kra" name="kra" placeholder="KRA" value="" maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="sex">Sex<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="sex" name="sex">
                                            <option value="M" title="Male">Male</option>
                                            <option value="F" title="Female">Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input autofocus type="email" class="form-control" id="email" name="email" placeholder="Email" value="" maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input autofocus type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" value="" maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="age">Age<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="age" name="id_type">
                                            <option value="adult" title="Adult">Adult</option>
                                            <option value="minor" title="Minor">Minor</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="id_type">ID Type<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="id_type" name="id_type">
                                            <option value="id" title="National">National ID</option>
                                            <option value="waiting" title="Waiting">Waiting Card</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="id_no">ID Number</label>
                                        <input autofocus type="text" class="form-control" id="id_no" name="id_no" placeholder="ID No" value="" maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password<span class="text-danger">*</span></label>
                                        <input autofocus type="password" class="form-control" id="password" name="password" placeholder="Password" value="" required maxlength="255">

                                    </div>

                                    <div class="form-group">
                                        <label for="pic">Picture</label>
                                        <input autofocus type="file" class="form-control-file" id="pic" name="pic"  value="">

                                    </div>

                                    <div class="">
                                        <h5>Trustee</h5>
                                    </div>

                                    <div class="form-group">
                                        <label for="guardian_first_name">First Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" placeholder="First Name" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_last_name">Last Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" placeholder="Last Name" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_id_no">ID Number</label>
                                        <input autofocus type="number" class="form-control" id="guardian_id_no" name="guardian_id_no" placeholder="ID No" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_email">Email</label>
                                        <input autofocus type="email" class="form-control" id="guardian_email" name="guardian_email" placeholder="Email" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_phone">Phone</label>
                                        <input autofocus type="tel" class="form-control" id="guardian_phone" name="guardian_phone" placeholder="Phone" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="guardian_relation">Relationship</label>
                                        <input autofocus type="tel" class="form-control" id="guardian_relation" name="guardian_relation" placeholder="Relationship" value="" maxlength="255">

                                    </div>

                                    <div class="">
                                        <h5>Next Of Kin</h5>
                                    </div>

                                    <div class="form-group">
                                        <label for="next_first_name">First Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="next_first_name" name="next_first_name" placeholder="First Name" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="next_last_name">Last Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="next_last_name" name="next_last_name" placeholder="Last Name" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="next_id_no">ID Number</label>
                                        <input autofocus type="text" class="form-control" id="next_id_no" name="next_id_no" placeholder="ID No" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="next_phone">Phone</label>
                                        <input autofocus type="tel" class="form-control" id="next_phone" name="next_phone" placeholder="Phone" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="next_email">Email</label>
                                        <input autofocus type="email" class="form-control" id="next_email" name="next_email" placeholder="Email" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="next_relation">Relationship</label>
                                        <input autofocus type="text" class="form-control" id="next_relation" name="next_relation" placeholder="Relationship" value="" maxlength="255">

                                    </div>

                                    <div class="">
                                        <h5>Bank Details</h5>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_name">Bank Name</label>
                                        <input autofocus type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="bank_branch">Bank Branch</label>
                                        <input autofocus type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Bank Branch" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="bank_full_name">Account Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="bank_full_name" name="bank_full_name" placeholder="Full Name" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                        <label for="bank_account">A/C<span class="text-danger">*</span></label>
                                        <input autofocus type="number" class="form-control" id="bank_account" name="bank_account" placeholder="Account Number" value="" maxlength="255">

                                    </div>
                                    <div class="form-group">
                                    <label for="swift">Swift<span class="text-danger">*</span></label>
                                    <input autofocus type="text" class="form-control" id="swift" name="swift" placeholder="Swift" value="" maxlength="255">

                                </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ route('dashboard.members.index') }}" class="btn btn-danger">Cancel</a>
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
