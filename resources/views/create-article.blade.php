@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <form class="edit-form" action="{{ '/article/create-confirm' }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                        <label for="description">Description:</label>
                        <input type="text" id="descriptiom" name="description" required>
                        
                        <label for="topic">Topic:</label>
                        <select id="topic" name="topic">
                            @foreach ($topics as $topic)
                               <option value="{{ $topic->name }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit">Save Changes</button>
                    </form>
                </div>
                <div class="article-image">
                    <img src="{{ asset('images/papai.jpg') }}" alt="Article Image">
                </div>

            </div>

    </section>
    
@include('partials.footer')

@endsection