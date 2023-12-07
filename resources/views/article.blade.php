@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <h1>{{ $article->name }}</h1>
                    <p>{{ $article->description }}</p>
                    <p>{{ $article->date }}</p>
                    <p><strong>Topic: </strong>{{ $topicName }}</p>
                    <p><strong>Likes: </strong> {{ $article->likes }}</p>
                    <p><strong>Dislikes: </strong> {{ $article->dislikes }}</p>
    
                    <a href="{{ url('profile/'.$article->user_id) }}" class="author-name"><strong>{{ $article->user->name }}</strong></a>
                    <p><strong>Author Reputation:</strong>{{$article->user->reputation}}</p>
                    <!--------------------------------LIKE----------------------------------------------------------------------->
                    <div>
                        @if($article_vote && $article_vote->is_like === TRUE)
                            <form action="{{ url('/articles/'.$article->article_id.'/unlike') }}" method="POST">
                                @csrf
                                <button type="submit" id="unlike-button"  class="fw-light nav-link fs-6"> <span class="fas fa-thumbs-up"> </span>
                                </button>
                            </form>
                        @else
                            <form action="{{ url('/articles/'.$article->article_id.'/like') }}" method="POST">
                                @csrf
                                <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                                <button type="submit" id="like-button" class="fw-light nav-link fs-6"> <span class="far fa-thumbs-up"> </span>
                                </button>
                        </form>
                        @endif
                        <p id="like-count"> {{ $likes }} </p>
                    </div>

                    <!-------------------------------------------DISLIKE--------------------------------------------------------------->
                    <div>
                        @if($article_vote && $article_vote->is_like === FALSE)
                            <form action="{{ url('/articles/'.$article->article_id.'/undislike') }}" method="POST">
                                @csrf
                                <button type="submit" id="undislike-button" class="fw-light nav-link fs-6"> <span class="fas fa-thumbs-down"> </span>
                                </button>
                            </form>
                        @else
                            <form action="{{ url('/articles/'.$article->article_id.'/dislike') }}" method="POST">
                                @csrf
                                <button type="submit" id="dislike-button" class="fw-light nav-link fs-6"> <span class="far fa-thumbs-down"> </span>
                                </button>
                            </form>
                        @endif
                        <p> {{ $dislikes }} </p>
                    </div>

                    <button class="share-button">Share</button>
                </div>
                <div class="article-image">
                    <img src="{{ asset('images/papai.jpg') }}" alt="Article Image">
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <!-- Aqui falta atualizar pagina dps do novo comment ser inserido -->
                    <form action="{{ '/comment/create' }}" method="post">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                        <label for="text">Leave a comment:</label>
                        <textarea name="text" id="text" cols="30" rows="5"></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>

                    <ul class="comment-list">
                        @foreach($comments as $comment)
                        <li><a href="{{ url('profile/'.$comment->user_id) }}" class="author-name2"><strong>{{$comment->user->name}}</strong></a>:{{$comment->text}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="popular-news-section">
                <h2>Most Popular News </h2>
                    <ul class="topic-list">
                            <li class="topic-item">
                                <a href="#">
                                    <div class="topic-image">
                                        <img src="{{ asset('images/teste-jpg') }}" alt="Article Image" class="popular-news-image">
                                        <div class="image-text">Lorem ipsum dolor</div>
                                    </div>
                                </a>
                            </li>
                            @foreach ($popular as $topArticle)
                            <li><a href="{{  url('articles/'.$topArticle->article_id) }}">{{ $topArticle->name }}</a></li>
                            @endforeach
                    </ul>
            </div>

    </section>
    
@include('partials.footer')

@endsection
