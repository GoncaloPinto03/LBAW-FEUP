@extends('layouts.app')
@include('partials.topbar')

@section('content')



@foreach($notifications as $notification)
    @if($notification->type === 'like_post')
        <p>{{ $notification->date }} -> User {{ $notification->emitter }} liked your post "{{ $notification->article }}"!!</p>
    @elseif($notification->type === 'dislike_post')
        <p>{{ $notification->date }} -> User {{ $notification->emitter }} disliked your post "{{ $notification->article }}"...</p>
    @elseif($notification->type === 'comment')
        <p>{{ $notification->date }} -> User {{ $notification->emitter }} just commented on your post "{{ $notification->article }}"!</p>
    @endif
@endforeach


@include('partials.footer')
@endsection