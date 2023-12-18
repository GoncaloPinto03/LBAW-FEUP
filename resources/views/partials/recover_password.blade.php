@extends('layouts.app')
<form method="POST" action="{{ route('password.update') }}" class="send-mail-form">
    <a href="{{ url('/home') }}" id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo"> 
    </a>
    @csrf
    <label for="email">Your email</label>
    <input id="email" type="email" name="email" required>
    <label for="password">New Password</label>
    <input id="password" type="password" name="password" required>
    <label for="password_confirmation">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>
    <button type="submit">Reset Password</button>
</form>
