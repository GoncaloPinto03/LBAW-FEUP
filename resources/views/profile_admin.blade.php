@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='profile'>
    <h1><strong>User Profile</strong></h1>
    <div class="profile-header">
        <div class="profile-pic">
            <img src={{ asset('images/profile/default_admin.png') }}>
        </div>
        <h2><strong>{{ $admin->name }}</strong><h2>
    </div>
    <div class='profile-info'>
        <p>Email: {{ $admin->email }}<p>
    </div>
    @if (Auth::guard('admin')->user()->admin_id == $admin->admin_id)
        <a href="{{ url('/admin-profile/edit') }}" class="button">Edit Profile</a>
    @endif
</section>
@endsection