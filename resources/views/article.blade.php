@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

<section id="articlebox">
    <!-- Main Article Box -->
    <div>
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <h1>{{ $article->name }}</h1>
                    <p>{{ $article->description }}</p>
                    <p>{{ \Carbon\Carbon::parse($article->date)->diffForHumans() }}</p>
                    <p><strong>Topic: </strong>{{ $topic->name }}</p>
                    @if ($tags->isNotEmpty())
                    <p><strong>Tags:</strong></p>
                    @foreach($tags as $tag)
                    <a href="{{ url('tag/'.$tag->tag_id) }}" class="tag-link"> #{{ $tag->tag->name }} </a>
                    @endforeach

                    @endif

                    @if ($article->user->name !== "Anonymous")
                    <a href="{{ url('profile/'.$article->user_id) }}" class="author-name"><strong>{{
                            $article->user->name }}</strong></a>
                    @else
                    <strong class="author-name" style="text-decoration:none;">{{ $article->user->name }}</strong>
                    @endif

                    <p><strong>Author Reputation: </strong>{{$article->user->reputation}}</p>
                    <p><strong>Author Followers: </strong>{{$article->user->number_followers}}</p>
                    <!--------------------------------LIKE ARTICLE----------------------------------------------------------------------->
                    @if(Auth::user())
                    @if(Auth::user()->user_blocked == 0 )
                    <div>
                        @if($article_vote && $article_vote->is_like === TRUE)
                        <form action="{{ url('/articles/'.$article->article_id.'/unlike') }}" method="POST">
                            @csrf
                            <button type="submit" id="unlike-button" class="fw-light nav-link fs-6"> <span
                                    class="fas fa-thumbs-up"> </span>
                            </button>
                        </form>
                        @else
                        <form action="{{ url('/articles/'.$article->article_id.'/like') }}" method="POST">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                            <button type="submit" id="like-button" class="fw-light nav-link fs-6"> <span
                                    class="far fa-thumbs-up"> </span>
                            </button>
                        </form>
                        @endif
                        <p id="like-count"> {{ $likes }} </p>
                    </div>
                    @endif


                    <!-------------------------------------------DISLIKE ARTICLE--------------------------------------------------------------->
                    @if(Auth::user()->user_blocked == 0 )
                    <div>
                        @if($article_vote && $article_vote->is_like === FALSE)
                        <form action="{{ url('/articles/'.$article->article_id.'/undislike') }}" method="POST">
                            @csrf
                            <button type="submit" id="undislike-button" class="fw-light nav-link fs-6"> <span
                                    class="fas fa-thumbs-down"> </span>
                            </button>
                        </form>
                        @else
                        <form action="{{ url('/articles/'.$article->article_id.'/dislike') }}" method="POST">
                            @csrf
                            <button type="submit" id="dislike-button" class="fw-light nav-link fs-6"> <span
                                    class="far fa-thumbs-down"> </span>
                            </button>
                        </form>
                        @endif
                        <p> {{ $dislikes }} </p>
                    </div>

                </div>
                @endif

                @if(Auth::user()->user_blocked == 0 && (Auth::user()->user_id != $article->user_id))
                <div>
                    <form action="{{ route('articles.mark-favourite', ['articleId' => $article->article_id]) }}"
                        method="POST">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                        <button type="submit" id="favouriteButton">
                            <span id="iconSpan" data-is-favourite="{{ $isFavourite ? 'true' : 'false' }}">
                                @if ($isFavourite)
                                <i class="bi bi-star-fill"></i>
                                @else
                                <i class="bi bi-star"></i>
                                @endif
                            </span>
                        </button>
                    </form>
                </div>
                @endif
                @endif





                @if ($article->photo())
                <div class="article-image">
                    <img src="{{ $article->photo() }}" alt="Article Image">
                </div>
                @endif







                @include('partials.comment_section', ['comments' => $comments])

            </div>



        </div>

</section>

@include('partials.footer')

@endsection