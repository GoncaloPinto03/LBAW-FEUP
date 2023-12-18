@extends('layouts.app')
@include('partials.topbar')

@section('content')


@if (!$notifications)
<p> No notifs </p>
@endif
@foreach($notifications as $notification)
    <p>{{ $notification->date }}  {{ $notification->notification_id }} {{ $notification->emitter_user }}  Notif </p>
@endforeach


@include('partials.footer')
@endsection