@extends('layouts.login')

@section('title', 'Login - Keloola')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
        <input id="email" name="email" type="email" required autofocus
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-red-300">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input id="password" name="password" type="password" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-red-300">
    </div>

    <div class="flex items-center justify-between mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="form-checkbox text-red-500">
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-sm text-red-500 hover:underline">Forgot your password?</a>
    </div>

    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-md">
        Sign in
    </button>

    <p class="mt-4 text-sm text-center text-gray-600">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-red-500 hover:underline">Register here</a>
    </p>
</form>
@endsection
