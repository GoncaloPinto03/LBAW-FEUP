@section('topbar')
    <div class="header-container">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button class="search-button">Search</button>
        </div>
        @if (Auth::check())
            <a href="{{ route('home') }}" class="button">Profile</a>
            <a class="button" href="{{ url('/logout') }}"> Logout </a>
        @else
            <a href="{{ route('login') }}" class="button">Sign In</a>
        @endif
    </div>
@endsection