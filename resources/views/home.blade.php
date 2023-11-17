@extends('layouts.app')
@include('partials.topbar')
@include('partials.sidebar')

@yield('sidebar')
@section('content')
    <section id="homepage23">
        @include('partials.articles_home')
    </section>
@endsection

@include('partials.footer')
