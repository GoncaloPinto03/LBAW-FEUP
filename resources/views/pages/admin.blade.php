<?php
?>

@extends('layouts.app')

@section('topbar')
    <div class="header-container">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div class="search-box">
            <form method="get" action="{{ url('/search-user') }}">
                <input type="search" name="query" class="search-input" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </div>
        @if (Auth::guard('admin')->check())
            <a href="{{ url('/profile_admin/'.Auth::guard('admin')->user()->admin_id) }}" class="button-signin">Profile</a>
            <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
        @elseif (Auth::check())
            <a href="{{ url('/profile/'.Auth::user()->user_id) }}" class="button-signin">Profile</a>
            <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
        @else
            <a href="{{ route('login') }}" class="button-signin">Sign In</a>
        @endif
    </div>

@endsection


@section('content')
    <section id="adminpage">
        <header>
            <h1>Admin Dashboard</h1>
        </header>
        <div class="adminpage-main">
            <div class="admin-container">
                <div class="admin-sidebar">
                    <ul>
                        <li><a>Users</a></li>
                        <li><a>Admins</a></li>
                        <li><a>Articles</a></li>
                        <li><a>Comments</a></li>
                        <li><a>Topics</a></li>
                        <li><a>Topic Proposals</a></li>
                        <li><a>User Reports</a></li>
                    </ul>
                </div>
                <div class="admin-dashboard">
                    @foreach($users as $user)
                        <div class="admin-dashboard-user">
                            <div class="admin-dashboard-user-info">
                                <img src="{{ $user->photo() }}" class="admin-dashboard-user-photo">
                                <p class="admin-dashboard-user-name">{{ $user->name }}</p>
                            </div>
                                <a href="{{ url('/profile/'.$user->user_id) }}" class="button">Profile</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
