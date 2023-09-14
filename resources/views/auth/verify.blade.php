@extends('layouts.app_auth')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="" class="h1"><b>@if(isset($settings)) {{ $settings->business_name }} @else {{ config('app.name', 'Laravel') }} @endif</b></a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">{{ __('Verify Your Email Address') }}</p>
        <p class="login-box-msg">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        <p class="login-box-msg">{{ __('If you did not receive the email') }}</p>
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf

            <button type="submit" class="btn btn-primary btn-block">{{ __('click here to request another') }}</button>

        </form>

    </div>
    <!-- /.card-body -->
</div>

@endsection
