@extends('layouts.app')

@section('content')

  <form method="POST" action="{{ route('register') }}" class="register-forms">
      <a href="{{ url('/home') }}" id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo"> 
      </a>
      {{ csrf_field() }}

      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" class="login-register-input" required autofocus>
      @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
      @endif

      <label for="email">E-Mail Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" class="login-register-input" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif

      <label for="password">Password</label>
      <input id="password" type="password" name="password" class="login-register-input" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif
      <p>Min 8 characters</p>

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" class="login-register-input" required>

      <button type="submit">
        Register
      </button>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
  </form>
@endsection