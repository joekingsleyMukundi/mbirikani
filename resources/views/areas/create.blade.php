@extends('layouts.app_settings')

@section('style')

@endsection

@section('content')


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">

                        <form method="post" action="{{ route('dashboard.areas.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input autofocus type="text" class="form-control" id="name" name="name" placeholder="Name" value="" required maxlength="255">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="asset_use_id">Land Category<span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="asset_use_id" name="asset_use_id">
                                            @foreach($uses as $use)
                                              <option value="{{ $use->id }}" title="{{ $use->name }}">{{ $use->name }}</option>
                                            @endforeach
                                        </select>
    
                                    </div>
                                </div>
                            </div>
            
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('dashboard.areas.index') }}" class="btn btn-danger">Cancel</a>
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
