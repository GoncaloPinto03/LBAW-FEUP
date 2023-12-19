@extends('layouts.app')
@include('partials.topbar')

@section('content')
    <section id="tag-articles">
        <h1>Artigos com a Tag: {{ $tag->name }}</h1>

        @if ($articles->count() > 0)
            <ul>
                @foreach ($articles as $article)
                    <li>
                        <a href="{{ url('articles/' . $article->article_id) }}">
                            {{ $article->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Não há artigos com esta tag.</p>
        @endif
    </section>

    <!-- Outras seções, rodapé, etc. -->

@include('partials.footer')

@endsection
