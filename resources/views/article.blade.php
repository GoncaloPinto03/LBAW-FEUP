@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">
<script src="{{ asset('js/redirect.js') }}"></script>

    <section id="articlebox">
        <!-- Main Article Box -->
        <div>
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <h1>{{ $article->name }}</h1>
                    <p>{{ $article->description }}</p>
                    <p>{{ $article->date }}</p>
                    <p><strong>Topic: </strong>{{ $topicName }}</p>
                    <p><strong>Likes: </strong> {{ $article->likes }}</p>
                    <p><strong>Dislikes: </strong> {{ $article->dislikes }}</p>

                    @if ($article->user->name !== "Anonymous")
                        @if(Auth::check()) 
                            <a href="{{ url('profile/'.$article->user_id) }}" class="author-name">
                                <strong>{{ $article->user->name }}</strong>
                            </a>
                        @else
                            <a href="#" class="author-name" data-toggle="modal" data-target="#loginModal">
                                <strong>{{ $article->user->name }}</strong>
                            </a>

                            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="loginModalLabel">Login Required</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span> <!-- close button not working -->
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>You need to be logged in to view the author's profile. Please log in or create an account.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="loginButton">Login</button> <!-- login button not working -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @else
                        <strong class="author-name" style="text-decoration:none;">{{ $article->user->name }}</strong>
                    @endif
                
                    <p><strong>Author Reputation:</strong>{{$article->user->reputation}}</p>
                    <!--------------------------------LIKE----------------------------------------------------------------------->
                @if(Auth::user())
                    @if(Auth::user()->user_blocked == 0 )
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
                    @endif
                

                    <!-------------------------------------------DISLIKE--------------------------------------------------------------->
                @if(Auth::user()->user_blocked == 0 )
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

                </div>
                @endif

                @if(Auth::user()->user_blocked == 0 && (Auth::user()->user_id != $article->user_id))
                    <div>
                        <form action="{{ route('articles.mark-favourite', ['articleId' => $article->article_id]) }}" method="POST">
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



            @if(Auth::user())
                @if ($isFavourite && (Auth::user()->user_id != $article->user_id))
                    <p style="color: #00003e; margin-left:30px;">Favourited </p>
                @elseif(Auth::user()->user_id != $article->user_id)
                    <p style="color: #00003e; margin-left:30px;">Not Favourited</p>
                @endif
            @endif

                <div class="article-image">
                    <img src="{{ $article->photo() }}" alt="Article Image">
                </div>


                

                <div class="comments-section">
                    <h2>Comments</h2>

                @if(Auth::user() )
                @if(Auth::user()->user_blocked == 0)
                    <!-- Aqui falta atualizar pagina dps do novo comment ser inserido -->
                    <form action="{{ '/comment/create' }}" method="post">
                        @csrf
                        <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                        <label for="text">Leave a comment:</label>
                        <textarea name="text" id="text" cols="30" rows="5"></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>
                @endif
                @endif

                    <ul class="comment-list">
                        @foreach($comments as $comment)
                        <li><a href="{{ url('profile/'.$comment->user_id) }}" class="author-name2"><strong>{{$comment->user->name}}</strong></a>:{{$comment->text}}
                        </li>
                        @endforeach
                    </ul>
                </div>
                
            </div>


    
    </div>
    
    </section>
    
@include('partials.footer')

@endsection
