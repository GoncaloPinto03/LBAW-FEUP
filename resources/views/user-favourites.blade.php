@extends('layouts.app')
@include('partials.topbar')

@section('content')

    <section id='user-favourite'>
        <h1 class="title">My Favourite Articles</h1>

        @if($favourites->count() == 0)
            <p>You have no favourite articles.</p>
        @else
            <div class="favourites-container">
                <ul>
                    @foreach($favourites as $favourite)
                    <div class="fav-list">
                        <li class="article-item">
                            <a href="{{ url('articles/'.$favourite->article->article_id) }}" class="article-button">
                                <span class="article-title">{{ $favourite->article->name }}</span>
                            </a>
                        </li>
                    </div>
                    @endforeach
                </ul>       
            </div>
        @endif  
    </section>
    @include('partials.footer')
@endsection