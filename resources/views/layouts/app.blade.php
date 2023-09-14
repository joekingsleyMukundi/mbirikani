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

    <style>
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 0px 10px;
        }
        table.dataTable tbody tr {
            padding: 0px 10px;
        }
    </style>
    @yield('style')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css')  }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

</head>
<body class="hold-transition sidebar-mini text-sm">
<div class="wrapper" id="app">
    <!-- Navbar -->
    @include('partials.top_menu')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('partials.left_sidebar_menu')
    <!-- /.main Sidebar Container -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @yield('content')

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

<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>

<script>
    $(function () {
        bsCustomFileInput.init();
    });
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
    $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Success',
        body: '{{ $message }}'
    })
    @endif
    @if ($message = Session::get('error'))
    $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Error',
        body: '{{ $message }}'
    })
    @endif
    @if ($message = Session::get('warning'))
    $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Success',
        body: '{{ $message }}'
    })
    @endif
    @if ($message = Session::get('info'))
    $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Success',
        body: '{{ $message }}'
    })
    @endif
    @if ($message = Session::has('message'))
    $(document).Toasts('create', {
        title: 'Message',
        body: '{{ $message }}'
    })
    @endif
    @if(count($errors)>0)
        @foreach($errors->all() as $error)
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Error',
                body: '{{ $error }}'
            })
        @endforeach
    @endif
    @if($import_errors = Session::get('import_errors'))
        @foreach($import_errors as $error)
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Error',
                body: '{{ $error }}'
            })
        @endforeach
    @endif
</script>
</body>
</html>
