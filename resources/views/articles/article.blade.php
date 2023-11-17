@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">
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

    <!-- Page itself -->
    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <h1>Messi o PIOR do mundo, GOAT PAPAI CRIS</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.</p>
                </div>

                <div class="article-image">
                    <img src="{{ asset('images/papai.jpg') }}" alt="Article Image">
                </div>

                <div class="comments-section">
                    <h2>Comments</h2>
                    <!-- Aqui falta atualizar pagina dps do novo comment ser inserido -->
                    <form action="{}" method="post">
                        @csrf
                        <label for="comment">Leave a comment:</label>
                        <textarea name="comment" id="comment" cols="30" rows="5"></textarea>
                        <button type="submit">Submit Comment</button>
                    </form>

                    <ul class="comment-list">
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                        <li>
                            <strong>Username:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="popular-news-section">
                <h2>Most Popular News </h2>
                    <ul class="topic-list">
                            <li><a href="#">Topic 1</a></li>
                            <li><a href="#">Topic 2</a></li>
                            <li><a href="#">Topic 3</a></li>
                            <li><a href="#">Topic 4</a></li>
                            <li><a href="#">Topic 5</a></li>
                    </ul>
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
