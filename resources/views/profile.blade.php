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
            @if(Auth::user() && Auth::user()->user_id != $user->user_id)
                @if(Auth::user()->isFollowing($user->user_id))
                    <form action="{{ url('/unfollow') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <button type="submit" class="button">Unfollow</button>
                    </form>
                @else
                    <form action="{{ url('/follow') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <button type="submit" class="button">Follow</button>
                    </form>
                @endif
            @endif
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
            
            @if($user->user_blocked == 0 && Auth::guard('admin')->check())
                <form action="{{ url('admin/block-user/'.$user->user_id)}}" method="POST">
                    @csrf
                    <button type="submit" id="#blockBtn">Block User</button>
                </form>
            @elseif($user->user_blocked == 1 && Auth::guard('admin')->check())
                <form action="{{ url('admin/unblock/'.$user->user_id)}}" method="GET">
                    @csrf
                    <button type="submit" id="#unblockBtn">Unblock User</button>
                </form>
            @endif
            @if(Auth::guard('admin')->check())
                <form action="{{ route('users.destroy', ['id' => $user->user_id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                        <button type="submit">Delete User</button>
                </form>
            @endif


            @if(Auth::user())
                @if(Auth::user()->user_id == $user->user_id)
                    <form action="{{ route('users.destroy_user', ['id' => $user->user_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action is irreversible.');">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                        <button type="submit" id="deleteUserBtn">Delete Account</button>
                    </form>
                @endif
            @endif
        @endif
        @if(Auth::user() && Auth::user()->user_id == $user->user_id && $user->user_blocked == 0)
                    <a href="{{ url('/user-favourites') }}" class="button">My Favorites</a>
        @endif

        
    </div>
    @include('partials.footer')
</section>

@endsection
