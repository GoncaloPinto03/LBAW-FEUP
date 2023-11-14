@extends('layouts.app')

@section('content')

<div id="sidebar">
        <h1 style="margin: 5px;">Topics</h1>
        <ul style="list-style-type: none; padding: 0; margin: 0;">
            <li><a href="#" style=><i class="fa-solid fa-gamepad" style="color: black; margin: 2px;"></i>Games</a></li>
            <li><a href="#" style=><i class="fa-regular fa-futbol" style="color: black; margin: 2px;"></i>Sports</a></li>
            <li><a href="#" style=><i class="fa-solid fa-briefcase" style="color: black; margin: 2px;"></i>Business</a></li>
            <li><a href="#" style=><i class="fa-brands fa-bitcoin" style="color: black; margin: 2px;"></i>Crypto</a></li>
            <li><a href="#" style=><i class="fa-solid fa-tv" style="color: black; margin: 2px;"></i>Television</a></li>
            <li><a href="#" style=>Celebrities</a></li>
        </ul>
    </div>

<div id="forms">
    <form method="POST" action="{{ route('login') }}">
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
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif

        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>

        <button type="submit">
            Login
        </button>
        <a class="button button-outline" href="{{ route('register') }}">Register</a>
        @if (session('success'))
            <p class="success">
                {{ session('success') }}
            </p>
        @endif
    </form>
</div>
@endsection