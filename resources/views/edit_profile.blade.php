@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='profile'>
    <h1><strong>Edit User Profile</strong></h1>
    <!-- Your form for editing profile information -->
    <form action="{{ url('/profile/edit') }}" method="post">
        @csrf

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <button type="submit">Save Changes</button>
    </form>
    </section>
@endsection