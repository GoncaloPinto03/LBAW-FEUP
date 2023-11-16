<!-- home.blade.php -->

@extends('layouts.app')

@section('content')
    <section id="homepage">
        <div>
            <h1>CollabNews</h1>
            <p>CollabNews is a news aggregator that allows you to create and share news stories with your friends and family.</p>

            @if (Auth::check())
                <a href="{{ route('home') }}" class="button">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="button">Login</a>
            @endif
        </div>
    </section>
@endsection
