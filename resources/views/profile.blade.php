@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='profile'>
    <div class="profile-box">
        <h1><strong>User Profile</strong></h1>
        <div class="profile-header">
            <div class="profile-pic">
                <img src="{{ $user->photo() }}">
            </div>
            <h2><strong>{{ $user->name }}</strong><h2>
        </div>
        <div class='profile-info'>
            <p>Email: {{ $user->email }}<p>
            <p>Reputation: {{ $user->reputation }}<p>
        </div>
        @if (Auth::guard('admin')->check() || Auth::user()->user_id == $user->user_id)
            <a href="{{ url('/profile/edit/' . $user->user_id) }}" class="button">Edit Profile</a>
            <a href= "{{ url('/profile/articles/'.$user->user_id) }}" class="button">Manage Articles</a>
            <form action="{{ url('/profile/delete') }}" method="post">
            @csrf
            @method('delete')
            <input type="hidden" name="user_id" value="{{ $user->user_id }}">
            <button type="submit" id="deleteAccountBtn" class="button-delete">Delete Acount</button>
        </form>
        @endif
    </div>
    @include('partials.footer')
</section>

@endsection
