@extends('layouts.app_auth')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="" class="h1"><b>@if(isset($settings)) {{ $settings->business_name }} @else {{ config('app.name', 'Laravel') }} @endif</b></a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">{{ __('Confirm Password') }}</p>
        <p class="login-box-msg">{{ __('Please confirm your password before continuing.') }}</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror

            </div>

            <button type="submit" class="btn btn-primary btn-block">{{ __('Confirm Password') }}</button>
        </form>
        <p class="mb-1">

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif

        </p>

    </div>
    <!-- /.card-body -->
</div>
@endsection
