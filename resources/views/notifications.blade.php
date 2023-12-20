@extends('layouts.app')
@include('partials.topbar')

@section('content')

<h1>Notification Page</h1>
<br>

<div class="notifs-dashboard">
    @foreach($notifications as $notification)
    @if ($notification->viewed === false)
        <div class="notif-unviewed">
    @else
        <div class="notif-viewed">
    @endif
            @if($notification->type === 'like_post')
                <p>{{ \Carbon\Carbon::parse($notification->date)->diffForHumans() }} -> User {{ $notification->emitter }} <strong>liked</strong> your post "{{ $notification->article }}"!!</p>
            @elseif($notification->type === 'dislike_post')
                <p>{{ \Carbon\Carbon::parse($notification->date)->diffForHumans() }} -> User {{ $notification->emitter }} <strong>disliked</strong> your post "{{ $notification->article }}"...</p>
            @elseif($notification->type === 'comment')
                <p>{{ \Carbon\Carbon::parse($notification->date)->diffForHumans() }} -> User {{ $notification->emitter }} just <strong>commented</strong> on your post "{{ $notification->article }}"!</p>
            @endif
        </div> 
    @endforeach
</div>


@include('partials.footer')
@endsection