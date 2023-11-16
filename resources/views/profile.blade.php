@extends('layouts.app')
@include('partials.topbar')

@section('content')
    <h1>This is user profile</h1>
    <h2>{{$user }}</h2>
@endsection