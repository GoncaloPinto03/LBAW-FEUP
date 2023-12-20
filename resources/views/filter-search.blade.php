@extends('layouts.app')

@section('topbar')

<div class="header-container">
    <a href="{{ url('/home') }} " id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;">
    </a>
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

@section('sidebar')
<div class="filter-page">
    <form action="">
        <div class="filter-topbar">
            <input type="text" placeholder="Search" name="search_text" class="filter-search">
            <article>
                <h3> Topic </h3>
                <div class="topics-list">
                    @foreach ($topics as $topic)
                        <div class="topic-section">
                            <input type="checkbox" name="topic[{{ $topic->topic_id }}]" value="{{ $topic->topic_id }}" class="topic-selector">
                            <p class="topic-filter-name"> {{ $topic->name }} </p>
                        </div>
                    @endforeach
                </div>
            </article>
        </div>
        <button type="submit" class="submit-topic-filter">Apply</button>
    </form>
</div>
@endsection

@section('content')

@foreach($articles as $article)
<div class="small-box" id="article{{ $article->article_id }}">
    <h2> {{ $article->name }} </h2>
    <p> {{ $article->description }} </p>
    <a href="{{ url('/articles/'.$article->article_id) }}" class="small-button">Read More </a>
</div>
@endforeach
@include('partials.footer')

@endsection