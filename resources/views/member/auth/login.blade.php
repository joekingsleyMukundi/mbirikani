@extends('member.layouts.app_auth')

@section('content')
<div class="card card-outline card-info">
    <div class="card-header text-center">
        <a href="" class="h1"><b>@if(isset($settings)) {{ $settings->business_name }} @else {{ config('app.name', 'Laravel') }} @endif</b></a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">{{ __('Member Login') }}</p>

        <form method="POST" action="{{ route('member.login') }}">
            @csrf

            <div class="input-group mb-3">
                <input id="membership_number" type="text" class="form-control @error('membership_number') is-invalid @enderror" placeholder="Membership Number" name="membership_number" value="{{ old('membership_number') }}" required autocomplete="membership_number" autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('membership_number')
                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                @enderror

            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                <div class="input-group-append  toggle-password">
                    <div class="input-group-text">
                        <span id="pass_view" class="fas fa-eye"></span>
                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                @enderror

            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-info">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-info btn-block">{{ __('Login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mb-1">
            @if (Route::has('password.request'))
                <a href="{{ route('member.password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </p>
    </div>
    <!-- /.card-body -->
</div>

@endsection
@section('script')
<script>
    $("body").on('click', '.toggle-password', function() {
  $('#pass_view').toggleClass("fa-eye fa-eye-slash");
  var input = $("#password");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }

});
</script>
@endsection
