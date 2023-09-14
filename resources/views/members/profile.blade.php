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
                                                    @if(isset($member->pic))
                                                        <img src="{{ $member->pic }}" class="profile-user-img img-fluid img-circle" alt="User Image">
                                                    @else
                                                        <i class="mt-2 fa fa-user fa-3x text-black"></i>
                                                    @endif
                                                </div>
                                                <h3 class="profile-username text-center">{{ $member->name }}</h3>
                                                <h5>Personal Details</h5>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>MGR Membership No</b> <a class="float-right">{{ $member->membership_number }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>MGR Co-op Society Membership No</b> <a class="float-right">{{ "MCS/" . $member->id }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Phone</b> <a class="float-right">{{ $member->phone }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right">{{ $member->email }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Date Of Birth</b> <a class="float-right">{{ $member->dob }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Marital Status</b> <a class="float-right">{{ $member->marital_status }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>ID Type</b> <a class="float-right">{{ $member->id_type }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>ID Number</b> <a class="float-right">{{ $member->id_no }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>KRA PIN</b> <a class="float-right">{{ $member->kra }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Sex</b> <a class="float-right">{{ $member->sex }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Age</b> <a class="float-right">{{ $member->age }}</a>
                                                    </li>

                                                </ul>
                                                <h5>Trustee Details</h5>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>First Name</b> <a class="float-right">{{ $member->guardian_first_name }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Last Name</b> <a class="float-right">{{ $member->guardian_last_name }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>ID Number</b> <a class="float-right">{{ $member->guardian_id_no }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right">{{ $member->guardian_email }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Phone</b> <a class="float-right">{{ $member->guardian_phone }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Relationship</b> <a class="float-right">{{ $member->guardian_relation }}</a>
                                                    </li>
                                                </ul>
                                                <h5>Next Of Kin Details</h5>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>First Name</b> <a class="float-right">{{ $member->next_first_name }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Last Name</b> <a class="float-right">{{ $member->next_last_name }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>ID Number</b> <a class="float-right">{{ $member->next_id_no }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right">{{ $member->next_email }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Phone</b> <a class="float-right">{{ $member->next_phone }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Relationship</b> <a class="float-right">{{ $member->next_relation }}</a>
                                                    </li>

                                                </ul>
                                                <h5>Bank Details</h5>
                                                <ul class="list-group list-group-unbordered mb-3">
                                                    <li class="list-group-item">
                                                        <b>Bank Name</b> <a class="float-right">{{ $member->bank_name }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Bank Branch</b> <a class="float-right">{{ $member->bank_branch }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Account Name</b> <a class="float-right">{{ $member->bank_full_name }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>A/C</b> <a class="float-right">{{ $member->bank_account }}</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Swift</b> <a class="float-right">{{ $member->swift }}</a>
                                                    </li>

                                                </ul>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-9">
                                        <div class="card card-primary">
                                            <div class="card-header p-2">
                                                <h3 class="card-title">Allotments</h3>
                                            </div>
                                            <div class="card-body">
                                                <table id="defautlTable" class="table table-bordered table-striped nowrap" style="width: 100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Group Ranch</th>
                                                        <th>Survey No</th>
                                                        <th>Title No</th>
                                                        <th>Hectares</th>
                                                        <th>Acres</th>
                                                        <th>Area</th>
                                                        <th>Category</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($member->allocations as $allocation)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $allocation->asset->name }}</td>
                                                            <td>{{ $allocation->parcel_no }}</td>
                                                            <td>{{ $allocation->survey_no }}</td>
                                                            <td>{{ round($allocation->acres/2.4710538146717,2) }}</td>
                                                            <td>{{ round($allocation->acres,2) }}</td>
                                                            <td>{{ $allocation->area->name }}</td>
                                                            <td>{{ $allocation->area->uses->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Group Ranch</th>
                                                        <th>Survey No</th>
                                                        <th>Parcel Number</th>
                                                        <th>Hectares</th>
                                                        <th>Acres</th>
                                                        <th>Area</th>
                                                        <th>Category</th>
                                                    </tr>
                                                    </tfoot>
                                                </table>
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
        });

    </script>
@endsection
