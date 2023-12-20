@extends('layouts.app')
@include('partials.topbar')


@section ('content')
        <div id="about-us">
            <h1 class="title-about">About <span>Collab News:</span></h1>

            <p class="text">Welcome to <strong>Collab News</strong>, where news comes alive through collaboration! We are a dynamic and innovative platform that thrives on the collective intelligence and diverse perspectives of our contributors.</p>
        <div class="about-box">
            <h2 class="subtitle">Our Mission: </h2>

            <p class="text-box">At <strong>Collab News</strong>, our mission is to deliver news that matters in a way that transcends traditional boundaries. We believe in the power of collaboration, where individuals from various backgrounds come together to share their insights and contribute to a richer, more nuanced understanding of the world.</p>
        </div>

        <div class="about-box">
            <h2 class="subtitle">Our Commitment: </h2>

            <p class="text-box">We are dedicated to upholding the highest standards of journalism ethics and integrity. Our commitment to accuracy, transparency, and accountability is unwavering. We strive to be a trusted source of information in an era where reliable news is more crucial than ever.</p>

        </div>

        <div class="about-box">
            <h2 class="subtitle">Join the Conversation: </h2>

            <p class="text-box"><strong>Collab News</strong> is not just a news platform; it's a community. We invite you to join the conversation, share your insights, and be a part of the collaborative spirit that defines us.</p>

            <p class="text-box">Thank you for being a part of our journey. Together, we are redefining the way news is delivered, one collaboration at a time.</p>

        </div>
        
        <p style="color:#00003e">If you have any questions or doubts, please contact:<a href="mailto:johndoe@example.com" class="email">johndoe@example.com</a> or <strong>+351 920 956 755</strong></p>


            
           
        </div>

    @include('partials.footer')


@endsection


