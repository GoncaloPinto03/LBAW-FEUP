@section('topbar')
    <div class="header-container">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button type="submit" class="search-button-user">Search</button>
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