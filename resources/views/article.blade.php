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
                    <div class="article-header">
                        <div class="article-header-left">
                            <h1>{{ $article->name }}</h1>
                            <p>{{ \Carbon\Carbon::parse($article->date)->diffForHumans() }}</p>
                        </div>
                        <div class="article-header-right">
                            <p><strong>Topic: </strong>{{ $topic->name }}</p>
                        </div>
                    </div>
                    @if ($article->user->name !== "Anonymous")
                    @if(Auth::check()) 
                        <a href="{{ url('profile/'.$article->user_id) }}" class="author-name">
                            <strong>{{ $article->user->name }}</strong>
                        </a>
                    @else
                        <a href="#" class="author-name" id="articleauthor">
                            <strong>{{ $article->user->name }}</strong>
                        </a>
                        <div class="error-msg" style="display:none;">
                            <p>You need to be logged in to view the profile.</p>
                            
                            <a href="{{ route('login') }}" id="loginLink" class="loginBtn">Login</a>
                            
                            <a id="closeBtn" class="xBtn">&times;</a>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var loginLink = document.getElementById('articleauthor');
                                var errorMsg = document.querySelector('.error-msg');
                                loginLink.addEventListener('click', function (event) {
                                    event.preventDefault();
                                    errorMsg.style.display = 'block';
                                    
                                });

                                closeBtn.addEventListener('click', function () {
                                    errorMsg.style.display = 'none';
                                });
                            });
                        </script>
                    @endif
                    @else
                        <strong class="author-name" style="text-decoration:none;">{{ $article->user->name }}</strong>
                    @endif

                    @if ($article->photo())
                        <div class="article-image">
                            <img src="{{ $article->photo() }}" alt="Article Image">
                        </div>
                    @endif
                    <div class="article-description">
                        <p>{{ $article->description }}</p>
                    </div>
                    @if ($tags->isNotEmpty())
                        @foreach($tags as $tag)
                        <a href="{{ url('tag/'.$tag->tag_id) }}" class="tag-link"> #{{ $tag->tag->name }} </a>
                        @endforeach
                    @endif
                    <p></p>
                    
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

                    @if(Auth::user()->user_blocked == 0 && (Auth::user()->user_id != $article->user_id))

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
                    @endif
                </div>
                @endif


                @endif









                @include('partials.comment_section', ['comments' => $comments])

            </div>



        </div>

</section>

@include('partials.footer')



@endsection