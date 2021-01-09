@extends('layouts.app')

@section('content')
<div class="login-page" style="min-height: 512.391px;">
  <div class="login-box">
    <div class="login-logo">
      <a class="navbar-brand" href="{{ url('/') }}">
        <b>{{ config("app.name", "Inventory Management System") }}</b>
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">{{ __('Login') }}</p>

        <form method="POST" action="{{ route('admin.login') }}">
          @csrf
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
              value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" autocomplete="off" required>
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
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
              id="password" placeholder="{{ __('Password') }}" autocomplete="off" required>
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
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember')
                  ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                  {{ __('Remember Me') }}
                </label>
              </div>
            </div>
          </div>
          <div class="social-auth-links text-center mb-3">
            <button type="submit" class="btn btn-primary btn-block">
              {{ __('Login') }}
            </button>
          </div>
        </form>

        <!-- /.social-auth-links -->
        @if (Route::has('admin.password.request'))
        <p class="mb-2">
          <a class="btn btn-link" href="{{ route('admin.password.request') }}">
            {{ __('Forgot Your Password?') }}
          </a>
        </p>
        @endif
        @if (Route::has('admin.register'))
        <p class="mb-2">
          <a class="nav-link" href="{{ route('admin.register') }}">{{ __("Register") }}</a>
        </p>
        @endif
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</div>
@endsection
