
@section('topbar')
    <div class="header-container">
        <a href="{{ url('/cards') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button class="search-button">Search</button>
        </div>
        <button class="sign-in-button">Sign In</button>
    </div>

@endsection