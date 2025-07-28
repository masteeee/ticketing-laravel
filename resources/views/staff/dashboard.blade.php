@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded border border-gray-200 mt-6">
    <h1 class="text-3xl font-bold text-blue-primary mb-4">Staff Dashboard</h1>
    <p class="text-gray-700">Welcome, {{ Auth::user()->name }} (Role: {{ Auth::user()->role ? Auth::user()->role->name : '-' }})!</p>

    <div class="mt-6">
        <a href="{{ route('logout') }}"
           class="inline-block px-4 py-2 bg-blue-primary text-white rounded hover:bg-blue-600">
            Logout
        </a>
    </div>
</div>
@endsection
