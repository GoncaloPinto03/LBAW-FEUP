@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='profile'>
    <h1><strong>User Profile</strong></h1>
    <div class="profile-header">
        <div class="profile-pic">
            <img src="{{ $user->photo() }}">
        </div>
        <h2><strong>{{ $user->name }}</strong><h2>
    </div>
    <div class='profile-info'>
        <p>Email: {{ $user->email }}<p>
        <p>Reputation: {{ $user->reputation }}<p>
    </div>
    @if (Auth::guard('admin')->check() || Auth::user()->user_id == $user->user_id)
    <a href="{{ url('/profile/edit') }}" class="button">Edit Profile</a>
    @endif
</section>
@endsection