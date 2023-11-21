<?php
?>

@extends('layouts.app')


@section('topbar')

<div class="header-container">
    <a href="{{ url('/home') }} " id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
    </a>
    <div class="search-box-user">
        <form method="get" action="{{ url('/search-user-post') }}" class="form-user">
            <input type="search" name="query" class="search-input-user" placeholder="Search...">
        </form>
        <button type="submit" class="search-button-user">Search</button>

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
    @foreach($articles as $article)
    <div class="small-box">
        <h2> {{ $article->name }} </h2>
        <p> {{ $article->description }} </p>
        <a href="{{ url('/articles/'.$article->article_id) }}" class="small-button">Read More </a>
        <a href="{{ url('/article/edit/'.$article->article_id) }}" class="small-button">Edit Article </a>
        <form action="{{ url('/article/delete') }}" method="post">
            @csrf
            @method('delete')
            <input type="hidden" name="article_id" value="{{ $article->article_id }}">
            <button type="submit" id="deleteArticleBtn" class="user-article-button">Delete Article</button>
        </form>
        
    </div>
    @endforeach
    @if (!Auth::guard('admin')->check())
        <a href="{{ '/article/create' }}" class="button">Create Article</a>
    @endif
    @include('partials.footer')
@endsection