@section('footer')

    <footer id="footer">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div id="footer-text">
            <a href="#">About Us</a>
            <p><i class="fa-regular fa-copyright" style="margin: 2px;"></i>LBAW Copyright</p>
        </div>
        
    </footer>

@endsection