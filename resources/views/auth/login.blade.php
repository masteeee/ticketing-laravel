@extends('layouts.login')

@section('title', 'Login - Keloola')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4 text-left">
        <label for="email" class="text-sm font-semibold text-gray-800 mb-1 inline-block">Email</label>
        <input id="email" name="email" type="email" required autofocus
               placeholder="contoh@gmail.com"
               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-red-300" />
    </div>

    <div class="mb-4 text-left">
        <label for="password" class="text-sm font-semibold text-gray-800 mb-1 inline-block">Password</label>
        <input id="password" name="password" type="password" required
               placeholder="••••••••"
               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-red-300" />
    </div>

    <div class="flex items-center justify-between mb-4 text-sm">
        <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="form-checkbox text-red-500">
            <span class="ml-2 text-gray-600">Ingat saya</span>
        </label>
    </div>

    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">
        Masuk
    </button>

</form>
@endsection
