@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <form class="edit-form" action="{{ url('/article/edit/'.$article->article_id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <label for="name">Name:</label>
                        <input type="text" value="{{ $article->name }}" id="name" name="name">
                        <label for="description">Description:</label>
                        <input type="text" value="{{ $article->description }}" id="descriptiom" name="description">
                        
                        <!--<h1>{{ $article->name }}</h1>
                        <p>{{ $article->description }}</p>-->
                        <button type="submit">Save Changes</button>
                    </form>
                    <p>{{ $article->date }}</p>
    
                    <p><strong>Author:</strong> {{ $article->user->name }}</p>
                </div>
                <div class="article-image">
                    <img src="{{ asset('images/papai.jpg') }}" alt="Article Image">
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <!-- Aqui falta atualizar pagina dps do novo comment ser inserido -->
                    <form action="{}" method="post">
                        @csrf
                        <label for="comment">Leave a comment:</label>
                        <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>

                    <ul class="comment-list">
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>    
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="popular-news-section">
                <h2>Most Popular News </h2>
                    <ul class="topic-list">
                            <li class="topic-item">
                                <a href="#">
                                    <div class="topic-image">
                                        <img src="{{ asset('images/teste.jpg') }}" alt="Article Image">
                                        <div class="image-text">Lorem ipsum dolor</div>
                                    </div>
                                </a>
                            </li>
                            <li><a href="#">Lorem ipsum dolor</a></li>
                            <li><a href="#">Lorem ipsum dolor</a></li>
                            <li><a href="#">Lorem ipsum dolor</a></li>
                            <li><a href="#">Lorem ipsum dolor</a></li>
                    </ul>
            </div>

    </section>
    
@include('partials.footer')

@endsection