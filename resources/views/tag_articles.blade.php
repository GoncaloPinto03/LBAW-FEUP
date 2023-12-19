@extends('layouts.app')
@include('partials.topbar')

@section('content')
    <section id="tag-articles">
        <h1>Artigos com a Tag: {{ $tag->name }}</h1>

        @if ($articles->count() > 0)
            <div class="additional-box-container">
                
                <!-- First Column -->
                <div class="column">
                    @php
                        $column1 = $articles->take($articles->count() / 2);
                    @endphp

                    @foreach ($column1 as $article)
                        <div class="small-box" data-category="{{ $article->category }}">
                            <h2>{{ $article->name }}</h2>
                            <p>{{ $article->description }}</p>
                            <a href="{{ url('articles/' . $article->article_id) }}" class="small-button">Read More</a>
                        </div>
                    @endforeach
                </div>

                <!-- Second Column -->
                <div class="column">
                    @php
                        $column2 = $articles->slice($articles->count() / 2);
                    @endphp

                    @foreach ($column2 as $article)
                        <div class="small-box" data-category="{{ $article->category }}">
                            <h2>{{ $article->name }}</h2>
                            <p>{{ $article->description }}</p>
                            <a href="{{ url('articles/' . $article->article_id) }}" class="small-button">Read More</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p>Não há artigos com esta tag.</p>
        @endif
    </section>

@include('partials.footer')

@endsection
