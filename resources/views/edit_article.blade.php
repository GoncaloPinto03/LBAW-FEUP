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
                        <label for="topic">Topic:</label>
                        <select id="topic" name="topic">
                            @foreach ($topics as $topic)
                               <option value="{{ $topic->name }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>     
                        <label for="image">Update Photo:</label>
                        <input type="file" id="image" name="image">                 
                        <button type="submit">Save Changes</button>
                    </form>
                    <p>{{ $article->date }}</p>
    
                    <p><strong>Author:</strong> {{ $article->user->name }}</p>
                </div>
                <div class="article-image">
                    <img src="{{ $article->photo() }}" alt="Article Image">
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                        @foreach($comments as $comment)  
                        <div id="comment{{ $comment->comment_id }}">
                                <a href="{{ url('profile/'.$comment->user_id) }}" class="author-name2"><strong>{{$comment->user->name}}</strong></a>: {{$comment->text}}
                                <form action="{{ url('/comment/delete') }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <input type="hidden" name="comment_id" value="{{ $comment->comment_id }}">
                                    <button type="submit" id="deleteCommentBtn" class="comment-delete-button"><i class="bi bi-trash"></i></button>
                                </form>   
                            </div> 
                        @endforeach   
                </div>
            </div>

            <div class="popular-news-section">
                <h2>Most Popular News </h2>
                    <ul class="topic-list">
                            <li class="topic-item">
                                <a href="#">
                                    <div class="topic-image">
                                        <img src="{{ $article->photo() }}" alt="Article Image">
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