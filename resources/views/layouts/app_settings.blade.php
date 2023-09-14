<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.css') }}">

    @yield('style')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')  }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#mytextarea', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
    <!-- Navbar -->
    @include('partials.top_menu')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('partials.left_sidebar_menu')
    <!-- /.main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

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
            <div class="row">
                <div class="col-md-3">
                    <div class="card">

                        <div class="card-body p-0" style="display: block;">
                            <ul class="nav nav-pills flex-column">
                                @can('settings:general')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.settings.general.index') }}" class="nav-link {{ request()->is('dashboard/settings/general') || request()->is('dashboard/settings/general*') ? 'active' : '' }}">
                                            <i class="fas fa-building"></i> General
                                        </a>
                                    </li>
                                @endcan
                                @can('roles:list')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.settings.roles.index') }}" class="nav-link {{ request()->is('dashboard/settings/roles') || request()->is('dashboard/settings/roles/*') ? 'active' : '' }}">
                                            <i class="fas fa-user-shield"></i> Roles
                                        </a>
                                    </li>
                                @endcan
                                @can('areas:list')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.areas.index') }}" class="nav-link {{ request()->is('dashboard/areas') || request()->is('dashboard/areas/*') ? 'active' : '' }}">
                                            <i class="fas fa-sitemap"></i> Areas
                                        </a>
                                    </li>
                                @endcan
                                @can('roles:list')
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.uses.index') }}" class="nav-link {{ request()->is('dashboard/uses') || request()->is('dashboard/uses/*') ? 'active' : '' }}">
                                            <i class="fas fa-object-group"></i> Land Categories
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{ $secondarytitle }}</h3>


                        </div>

                        <div class="card-body p-0">

                            @yield('content')

                        </div>


                    </div>

                </div>

            </div>

        </section>


    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; {{ date('Y') }} <a href="https://webmasters.co.ke">Webmasters Kenya</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> {{ config('app.version', '1.0.0') }}
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jqueryui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ asset('plugins/form-builder/form-builder.min.js') }}"></script>

<script src="{{ asset('plugins/form-builder/form-render.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2(
            {
                width: '100%'
            }
        );
    });
</script>
@yield('script')

<script>
    @if ($message = Session::get('success'))
    toastr.success('{{ $message }}')
    @endif
    @if ($message = Session::get('error'))
    toastr.error('{{ $message }}')
    @endif
    @if ($message = Session::get('warning'))
    toastr.warning('{{ $message }}')
    @endif
    @if ($message = Session::get('info'))
    toastr.info('{{ $message }}')
    @endif
    @if ($message = Session::has('message'))
    toastr.error('{{ $message }}')
    @endif
    @if(count($errors)>0)
    @foreach($errors->all() as $error)
    toastr.error('{{ $error }}')
    @endforeach
    @endif
</script>
</body>
</html>
