@extends('layouts.app')
@include('partials.topbar')

@section('content')
<link rel="stylesheet" href="{{ asset('css/article_pages.css') }}">

    <section id="articlebox">
        <!-- Main Article Box -->
        <div class="boxes-container">
            <div class="article-box">
                <div class="article-content">
                    <form class="edit-form" action="{{ '/article/create-confirm' }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name">
                        <label for="description">Description:</label>
                        <input type="text" id="descriptiom" name="description">

                        <label for="topic">Topic:</label>
                        <select id="topic" name="topic">
                            @foreach ($topics as $topic)
                               <option value="{{ $topic->name }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>

                        <label for="image">Insert Photo:</label>
                        <input type="file" id="image" name="image">                 
                        

                        <button type="submit">Save Changes</button>
                    </form>
                </div>
                

            </div>

    </section>
    
@include('partials.footer')

@endsection