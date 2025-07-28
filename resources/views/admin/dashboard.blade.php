@extends('layouts.admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard {{ Auth::user()->name }}</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
@endsection
