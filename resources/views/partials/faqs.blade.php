@extends('layouts.app')
@include('partials.topbar')

@section('content')
    <div id="faqs">
        <h1 class="title">Frequently Asked Questions</h1>

        <p class="text">Welcome to our FAQ page. Here, we aim to address common queries and provide helpful information to enhance your experience with <strong>Collab News</strong>.</p>

        <div class="faq-box">
            <h2 class="subtitle">What is Collab News?</h2>

            <p class="text-box">Collab News is a dynamic and innovative news platform that thrives on collaboration. Our contributors, representing diverse backgrounds, come together to share insights and contribute to a richer, more nuanced understanding of the world.</p>
        </div>

        <div class="faq-box">
            <h2 class="subtitle">How can I contribute to Collab News?</h2>

            <p class="text-box">Contributing to Collab News is easy! Simply create an account, and you can start sharing your articles and insights with our community. We believe in the power of collective intelligence, and your voice matters.</p>
        </div>

        <div class="faq-box">
            <h2 class="subtitle">What sets Collab News apart?</h2>

            <p class="text-box">Collab News stands out for its commitment to journalism ethics and integrity. We prioritize accuracy, transparency, and accountability, striving to be a trusted source of information in today's media landscape.</p>
        </div>

        <div class="faq-box">
            <h2 class="subtitle">Join the Collaborative Spirit</h2>

            <p class="text-box">Collab News is more than a news platform; it's a community. We invite you to join the conversation, share your insights, and be part of the collaborative spirit that defines us. Thank you for being part of our journey!</p>
        </div>
    </div>

    @include('partials.footer')
@endsection
