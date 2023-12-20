@extends('layouts.app')
<form method="POST" action="/send" class="send-mail-form">
    <a href="{{ url('/home') }}" id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo"> 
    </a>
    @csrf
    <label for="name">Your name</label>
    <input id="name" type="text" name="name" required>
    <label for="email">Your email</label>
    <input id="email-mailtrap" type="email" name="email" required>
    <button type="submit">Send</button>
</form>
