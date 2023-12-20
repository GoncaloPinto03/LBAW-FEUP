@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

<section class="edit-comment-page">
    <div class="edit-comment-section">
        <form action="{{ '/comment/edit/'.$comment->comment_id }}" method="post">
            @csrf
            <label for="comment">Comment:</label>
            <textarea name="text" id="text" cols="30" rows="5" value="{{ $comment->text }}" class="edit-comment-input"></textarea>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</section>

@include('partials.footer')

@endsection