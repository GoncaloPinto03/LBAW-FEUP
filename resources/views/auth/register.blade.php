@extends('layouts.app')

@section('content')
<div id="forms"> 
  <form method="POST" action="{{ route('register') }}">
      <a href="{{ url('/cards') }}" id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo"> 
      </a>
      {{ csrf_field() }}

      <label for="name">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
      @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
      @endif

      <label for="email">E-Mail Address</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required>
      @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
      @endif

      <label for="password">Password</label>
      <input id="password" type="password" name="password" required>
      @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
      @endif

      <label for="password-confirm">Confirm Password</label>
      <input id="password-confirm" type="password" name="password_confirmation" required>

      <button type="submit">
        Register
      </button>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
  </form>
</div>
@endsection