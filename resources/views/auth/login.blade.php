@extends('layouts.login')

@section('title', 'Login - Keloola')

@section('content')
<h2 class="text-center text-xl font-semibold text-gray-800 mb-4">Sign in to your account</h2>

<form method="POST" action="{{ route('login') }}" class="space-y-4 mx-auto max-w-xs">
    @csrf

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
        <input id="email" name="email" type="email" required
               class="block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500"
               placeholder="you@example.com">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input id="password" name="password" type="password" required
               class="block w-full rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:ring-red-500"
               placeholder="••••••••">
    </div>

    <div class="flex items-center justify-between text-sm">
        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox"
                   class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
            <label for="remember_me" class="ml-2 text-gray-700">Remember me</label>
        </div>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-red-600 hover:underline">Forgot your password?</a>
        @endif
    </div>

    <div class="flex justify-center">
        <button type="submit"
                class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Sign in
        </button>
    </div>

    <div class="text-center text-sm mt-4">
        <span class="text-gray-600">Don't have an account?</span>
        <a href="{{ route('register') }}" class="text-red-600 hover:underline">Register here</a>
    </div>
</form>
@endsection
