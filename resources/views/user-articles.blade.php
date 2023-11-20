<?php
?>

@extends('layouts.app')
@include('partials.topbar')

@section('content')
    @foreach($articles as $article)
    <div class="small-box">
        <h2> {{ $article->name }} </h2>
        <p> {{ $article->description }} </p>
        <a href="{{ url('/articles/'.$article->article_id) }}" class="small-button">Read More </a>
        <a href="{{ url('/article/edit/'.$article->article_id) }}" class="small-button">Edit Article </a>
        <form action="{{ url('/article/delete') }}" method="post">
            @csrf
            @method('delete')
            <input type="hidden" name="article_id" value="{{ $article->article_id }}">
            <button type="submit">Delete Article</button>
        </form>
        
    </div>
    @endforeach
    <a href="{{ '/article/create' }}" class="button">Create Article</a>
@endsection