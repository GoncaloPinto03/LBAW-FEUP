@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='edit-profile'>
    <h1><strong>Edit User Profile</strong></h1>
    <form class="edit-form" action="{{ url('/profile/edit') }}" enctype="multipart/form-data" method="post">
        @csrf
        <section class="edit-profile-pic-options">
            <section class="profile-pic">
                <img id="edit-profile-pic" class="edit-profile-pic" src="{{ $user->photo() }}" width=60% alt="Profile Picture">
            </section>
            <h4 for="image"> Choose a profile picture:</h4>
            <input type="file" name="image" id="image">
        </section>
        <section class="edit-profile-options">
            <label for="name">Name:</label>
            <input placeholder="New name" type="text" value="{{ $user->name }}" id="name" name="name">
            <br>
            <label for="email">Email:</label>
            <input placeholder="New email" type="text" value="{{ $user->email }}" id="email" name="email"55>
        </section>
        <button type="submit">Save Changes</button>
    </form>
    </section>
@endsection