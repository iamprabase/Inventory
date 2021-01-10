<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Inventory Management System') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
      html,
      body {
        background-color: #6a54a873;
        color: #000286;
        font-family: 'Montserrat', sans-serif;
        font-weight: 400;
        height: 100vh;
        margin: 0;
      }

      .full-height {
        height: 100vh;
      }

      .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
      }

      .position-ref {
        position: relative;
      }

      .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
      }

      .content {
        text-align: center;
      }

      .title {
        font-size: 84px;
      }

      .links>a {
        color: #fff;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
      }

      .m-b-md {
        margin-bottom: 30px;
      }

    </style>
  </head>

  <body>
    <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="title m-b-md">
        <strong>
        {{config('app.name', 'Inventory Manageent System')}}
        </strong>
      </div>
      @if (Route::has('admin.login'))
      <div class="links">
        @auth
        <a href="{{ route('admin.dashboard') }}">Home</a>
        @else
        <a href="{{ route('admin.login') }}">Login</a>

        @if (Route::has('admin.register'))
        <a href="{{ route('admin.register') }}">Register</a>
        @endif
        @endauth
        <!-- @if (Route::has('staff.login'))
        @auth
        <a href="{{ route('staff.dashboard') }}">Home</a>
        @else
        <a href="{{ route('staff.login') }}">Staff Login</a>

        @if (Route::has('staff.register'))
        <a href="{{ route('staff.register') }}">Staff Register</a>
        @endif
        @endauth
        @endif -->
      </div>
      @endif
    </div>
    </div>
  </body>

</html>