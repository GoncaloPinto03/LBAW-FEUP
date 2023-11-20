@extends('layouts.app')
@include('partials.topbar')

@section('content')
<section id='edit-profile'>
    <h1><strong>Edit Admin Profile</strong></h1>
    <form class="edit-form" action="{{ url('/admin-profile/edit') }}" enctype="multipart/form-data" method="post">
        @csrf
        <section class="edit-profile-options">
            <label for="name">Name:</label>
            <input placeholder="New name" type="text" value="{{ $admin->name }}" id="name" name="name">
            <br>
            <label for="email">Email:</label>
            <input placeholder="New email" type="text" value="{{ $admin->email }}" id="email" name="email">
        </section>
        <button type="submit">Save Changes</button>
    </form>
    </section>
@endsection