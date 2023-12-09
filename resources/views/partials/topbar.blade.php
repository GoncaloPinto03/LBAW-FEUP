@section('topbar')
    <div class="header-container">
        @if (Auth::guard('admin')->check())
            <a href="{{ url('/admin/')}} " id="form-logo">
                <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
            </a>
        @else
            <a href="{{ url('/home') }} " id="form-logo">
                <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
            </a>
        @endif
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search..." style="background-color:white;">
            <button type="submit" class="search-button">Search</button>
        </div>
        @if (Auth::guard('admin')->check())
            <a href="{{ url('/profile_admin/'.Auth::guard('admin')->user()->admin_id) }}" class="button-signin">Profile</a>
            <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
        @elseif (Auth::check())
            @if(Auth::user()->user_blocked == 0)
                <a href="{{ '/article/create' }}" class="button-signin">Create Article</a>
            @endif
            
            <a href="{{ url('/profile/'.Auth::user()->user_id) }}" class="button-signin">Profile</a>
            <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
        @else
            <a href="{{ route('login') }}" class="button-signin">Sign In</a>
        @endif
    </div>
@endsection