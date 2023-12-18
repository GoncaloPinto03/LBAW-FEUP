@extends('layouts.app')

@section('content')

    <form method="POST" action="{{ route('login') }}" class="login-forms">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo"> 
        </a>
        {{ csrf_field() }}

        <label for="email">E-mail</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if ($errors->has('email'))
            <span class="error">
            {{ $errors->first('email') }}
            </span>
        @endif

        <label for="password" >Password</label>
        <input id="password" type="password" name="password" required>
        <a href="{{ route('send-mail') }}">Forgot your password?</a>
        <br>
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <button type="submit">
            Login
        </button>
        <a class="no-account-button" href="{{ route('register') }}">Don't have an account!</a>
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </form>

@endsection