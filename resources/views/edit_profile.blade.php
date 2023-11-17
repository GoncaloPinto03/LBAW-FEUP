@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='profile'>
    <h1><strong>Edit User Profile</strong></h1>
    <!-- Your form for editing profile information -->
    <form action="{{ url('/profile/edit') }}" method="post">
        @csrf
        <section class="edit-profile-pic-options">
            <img id="edit-profile-pic" class="edit-profile-pic" src=" {{ Auth::user()->photo() }}" alt="Profile Picture">
            <h4 for="image"> Choose a profile picture:</h4>
            <input type="file" name="image" id="image">
        </section>
        <label for="name">Name:</label>
        <input placeholder="New name" type="text" id="name" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input placeholder="New email" type="text" id="email" name="email" required>
        <button type="submit">Save Changes</button>
    </form>
    </section>
@endsection