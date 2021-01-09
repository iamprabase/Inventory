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
        <p class="login-box-msg">{{ __('Reset Password') }}</p>

        <form method="POST" action="{{ route('admin.password.update') }}">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">

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

          <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
              class="form-control @error('password') is-invalid @enderror" id="password-confirm"
              placeholder="{{ __('Confirm Password') }}" autocomplete="off" required>
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
          <div class="social-auth-links text-center mb-3">
            <button type="submit" class="btn btn-primary btn-block">
              {{ __('Reset Password') }}
            </button>
          </div>
        </form>
        <p class="mb-2">
          <a class="btn btn-link" href="{{ route('admin.login') }}">
            {{ __('Login') }}
          </a>
        </p>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
</div>
@endsection
