@extends('layouts.app')
@include('partials.topbar')


@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">
<script src="https://kit.fontawesome.com/dbd6c8e80d.js" crossorigin="anonymous"></script>

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
                    <button id="like"><i class="fa-regular fa-thumbs-up" style="font-size:20px;"></i></button>
                    <button id="dislike"><i class="fa-regular fa-thumbs-down" style="font-size:20px;"></i></button>
                </div>
                <div class="article-image">
                    <img src="{{ $article->photo() }}" alt="Article Image">
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
                                        <img src="{{ $article->photo() }}" alt="Article Image">
                                        <!--<div class="image-text">Lorem ipsum dolor</div> -->
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Like button
        var likeButton = document.getElementById('like');
        likeButton.addEventListener('click', function() {
            toggleButtonState(likeButton, 'liked', 'fa-regular fa-thumbs-up', 'fa-solid fa-thumbs-up');
        });


        // Dislike button
        var dislikeButton = document.getElementById('dislike');
        dislikeButton.addEventListener('click', function() {
            toggleButtonState(dislikeButton, 'disliked', 'fa-regular fa-thumbs-down', 'fa-solid fa-thumbs-down');
        });

        // Function to toggle button state
        function toggleButtonState(button, className, regularIcon, solidIcon) {
            if (button.classList.contains(className)) {
                button.classList.remove(className);
                button.innerHTML = '<i class="' + regularIcon + '" style="font-size:20px;"></i>';
            } else {
                button.classList.add(className);
                button.innerHTML = '<i class="' + solidIcon + '" style="font-size:20px;"></i>';
            }
        }
    });
</script>
