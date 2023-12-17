@extends('layouts.app')
@section('topbar')
<div class="header-container">
    <a href="{{ url('/home') }} " id="form-logo">
        <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;">
    </a>
    <div class="search-box-admin">
        <form method="get" action="{{ url('/search-user') }}" class="form-admin">
            <input type="search" name="query" class="search-input-admin" placeholder="Search...">
        </form>
        <button type="submit" class="search-button-admin">Search</button>

    </div>
    @if (Auth::guard('admin')->check())
    <a href="{{ url('/profile_admin/'.Auth::guard('admin')->user()->admin_id) }}" class="button-signin">Profile</a>
    <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
    @elseif (Auth::check())
    <a href="{{ url('/profile/'.Auth::user()->user_id) }}" class="button-signin">Profile</a>
    <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
    @else
    <a href="{{ route('login') }}" class="button-signin">Sign In</a>
    @endif
</div>

@endsection

@section('content')
<section id="adminpage">
    <div class="adminpage-main">
        <div class="admin-container">
            <div class="admin-sidebar">
                <ul>
                    <li><a href="{{ url('/admin/users/') }}">Users</a></li>
                    <li><a href="{{ url('/admin/topics/') }}">Topics</a></li>
                    <li><a href="{{ url('/admin/topicproposals/') }}">Topic Proposals</a></li>
                    <li><a>User Reports</a></li>
                </ul>
            </div>
            <div class="admin-dashboard" id="admin-content">
                @foreach($topicproposals as $topicproposal)
                @if ($topicproposal->accepted === null)
                <div class="admin-dashboard-user" id="topicproposal{{$topicproposal->topicproposal_id}}">
                    <div>
                        <p>{{ $topicproposal->name }}</p>
                        <form action="{{ url('/admin/topicproposals/'.$topicproposal->topicproposal_id.'/accept') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="topicproposal_id" value="{{ $topicproposal->topicproposal_id }}">
                            <button id="acceptTopicProposalBtn" type="submit"><i class="bi bi-check-lg"></i> Accept</button>
                        </form>
                        <form action="{{ url('/admin/topicproposals/'.$topicproposal->topicproposal_id.'/deny') }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="topicproposal_id" value="{{ $topicproposal->topicproposal_id }}">
                            <button id="denyTopicProposalBtn" type="submit"><i class="bi bi-x-lg"></i> Deny</button>
                        </form>
                    </div>
                </div>
                @endif
                @endforeach

            </div>
        </div>
    </div>
</section>
@endsection