@section('footer')

    <footer id="footer">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div id="footer-text">
            <a href="{{url('/main-features')}}">Main Features</a>
            <a href="{{url('/faqs')}}">FAQs</a>
            <a href="{{url('/about')}}">About Us</a>
            <p>&copy LBAW Copyright</p>
        </div>
        
    </footer>

@endsection
