@extends('layouts.app')

@section('content')

    <!-- Search bar and top things -->
    <div class="header-container">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button class="search-button"><i class="fa-solid fa-magnifying-glass" style="color: #5a86ba;  font-size: 20px;"></i></button>
        </div>
        @if (Auth::check())
            <a href="{{ route('home') }}" class="button">Profile</a>
            <a class="button-signin" href="{{ url('/logout') }}"> Logout </a>
        @else
            <a href="{{ route('login') }}" class="button-signin">Sign In</a>
        @endif
    </div>
    <head>
        <script src="https://kit.fontawesome.com/dbd6c8e80d.js" crossorigin="anonymous"></script>

    </head>

    <!-- Page itself -->
    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-image">
                    <img src="{{ asset('images/papai.jpg') }}" alt="Article Image">
                </div>
                <div class="article-content">
                    <h1>Messi o PIOR do mundo, GOAT PAPAI CRIS</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
                    <a href="#" class="button">Read More</a>
                </div>
            </div>

            <div class="additional-box-container">
                <!-- First Column -->
                <div class="column">
                    <div class="small-box">
                        <h2>Additional Small Box 1 Title</h2>
                        <p>Additional Small Box 1 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 2 Title</h2>
                        <p>Bme vindo a vila moleza, o Porto aqui vai jogar e vai ganhar</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 3 Title</h2>
                        <p>Additional Small Box 3 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>
                    
                    <div class="small-box">
                        <h2>Additional Small Box 3 Title</h2>
                        <p>Additional Small Box 3 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>
                </div>

                <!-- Second Column -->
                <div class="column">
                    <div class="small-box">
                        <h2>Additional Small Box 4 Title</h2>
                        <p>Additional Small Box 4 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 5 Title</h2>
                        <p>Bme vindo a vila moleza, o Porto aqui vai jogar e vai ganhar</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 6 Title</h2>
                        <p>Additional Small Box 6 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>

                    <div class="small-box">
                        <h2>Additional Small Box 6 Title</h2>
                        <p>Additional Small Box 6 Content</p>
                        <a href="#" class="small-button">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        </div>

       
            <div class="small-box-container">
                <div class="small-box">
                    <h2>Small Box 1 Title</h2>
                    <p>Bem vindos a vila moleza, o lugar onde vais querer estar</p>
                    <a href="#" class="small-button">Read More</a>
                </div>

                <div class="small-box">
                    <h2>Small Box 2 Title</h2>
                    <p>Small Box 2 Content</p>
                    <a href="#" class="small-button">Read More</a>
                </div>

                <div class="small-box">
                    <h2>Small Box 3 Title</h2>
                    <p>Small Box 3 Content</p>
                    <a href="#" class="small-button">Read More</a>
                </div>

                <div class="small-box">
                    <h2>Small Box 4 Title</h2>
                    <p>Small Box 4 Content</p>
                    <a href="#" class="small-button">Read More</a>
                </div>
                <div class="small-box">
                    <h2>Small Box 4 Title</h2>
                    <p>Small Box 4 Content</p>
                    <a href="#" class="small-button">Read More</a>
                </div>
            </div>

    </section>

    <!-- Footer -->

    <footer id="footer">
        <a href="{{ url('/home') }} " id="form-logo">
            <img src="{{ asset('images/logo_big.png') }}" alt="CollabNews Logo" id="header-logo" style="width:100px;"> 
        </a>
        <div id="footer-text">
        <a href="#">About Us</a>
            <p>LBAW Copyright</p>
        </div>
        
    </footer>

@endsection
