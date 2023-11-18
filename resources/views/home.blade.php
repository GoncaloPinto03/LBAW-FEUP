@extends('layouts.app')
@include('partials.topbar')
@include('partials.sidebar')

@yield('sidebar')
@section('content')
    <section id="adminpage">
        <div>
            <h2>Users</h2>

            <ul>
                @foreach($users as $user)
                    <li>{{ $user->name }} - {{ $user->email }}</li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection
