@extends('layouts.app')

@section('content')
<div class="register-page" style="min-height: 512.391px;">
  <div class="register-box">
    <div class="register-logo">
      <a class="navbar-brand" href="{{ url('/') }}">
        <b>{{ config("app.name", "Inventory Management System") }}</b>
      </a>
    </div>
    <!-- /.register-logo -->
    <div class="card">
      <div class="card-body register-card-body">
        <p class="register-box-msg">{{ __('Login') }}</p>

        <form method="POST" action="{{ route('admin.register') }}">
          @csrf
          <div class="input-group mb-3">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
             @error('name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
          </div>
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
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="is_admin" class="form-check-input" id="is_admin" {{ old('is_admin')
                  ? 'checked' : '' }}>
                <label class="form-check-label" for="is_admin">
                  Is Admin
                </label>
              </div>
            </div>
          </div> -->
          <div class="social-auth-links text-center mb-3">
            <button type="submit" class="btn btn-primary btn-block">
              {{ __('Register') }}
            </button>
          </div>
        </div>

        </form>

        <!-- /.social-auth-links -->
        <p class="mb-2">
          <a class="btn btn-link" href="{{ route('admin.login') }}">
            {{ __('Already a Member?') }}
          </a>
        </p>
      </div>
      <!-- /.register-card-body -->
    </div>
  </div>
  <!-- /.register-box -->
</div>
@endsection


