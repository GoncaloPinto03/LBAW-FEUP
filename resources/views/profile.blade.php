@extends('layouts.app')
@include('partials.topbar')

@section('content')
    <h1>User Profile</h1>
    <section id='profile'>
        <div class="profile-pic">
            <img src="{{ asset('images/default_pic.jpg')}}">
        </div>
        <h2><strong>{{ $user->name }}</strong><h2>
        <p>Email: {{ $user->email }}<p>
        <p>Reputation: {{ $user->reputation }}<p>
    </section>
    @if (Auth::user()->user_id == $user->user_id)
        <a href="{{ url('/home') }}" class="button">Edit Profile</a>
    @endif
@endsection