@extends('layouts.app')
@include('partials.topbar')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
<section id="homepage23">
    @include('partials.articles_home')
</section>
@endsection

@include('partials.footer')

