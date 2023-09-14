@extends('member.layouts.app_auth')

@section('content')
<div class="card card-outline card-info">
    <div class="card-header text-center">
        <a href="" class="h1"><b>@if(isset($settings)) {{ $settings->business_name }} @else {{ config('app.name', 'Laravel') }} @endif</b></a>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <p class="login-box-msg">{{ __('Reset Password') }}</p>

        <form method="POST" action="{{ route('member.password.email') }}">
            @csrf

            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

            </div>

            <button type="submit" class="btn btn-info btn-block">{{ __('Send Password Reset Link') }}</button>
        </form>

    </div>
    <!-- /.card-body -->
</div>
@endsection
