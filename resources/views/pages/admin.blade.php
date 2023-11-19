<?php
?>

@extends('layouts.app')
@include('partials.topbar')

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
