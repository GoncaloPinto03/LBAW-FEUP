@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

<section id="articlebox">
    <div class="boxes-container">
        <div class="article-box">
            <div class="article-content">
                <form class="edit-form" action="{{ route('topic.propose') }}" method="post">
                    @csrf
                    <label for="name">Topic Name:</label>
                    <input type="text" id="name" name="name" required>
                    <button type="submit">Propose Topic</button>
                </form>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')

@endsection
