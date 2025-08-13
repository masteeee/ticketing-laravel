<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Keloola')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/output.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')
</head>    

<body class="bg-white-primary text-black-keloola">
    <nav class="bg-white-primary shadow relative">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('public.home') }}">
                    <img src="{{ asset('assets/keloola-logo.png') }}" alt="Logo" class="w-20 h-20 object-contain">
                </a>
            </div>
            <ul class="hidden md:flex items-center space-x-6 font-medium" id="nav-menu">
                <li>
                    <a href="{{ url('/') }}"
                       class="{{ request()->is('/') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                       Home
                    </a>
                </li>
                <li>
                    <a href="{{ url('/knowledge') }}"
                       class="{{ request()->is('knowledge') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                       Knowledge Base
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}"
                       class="{{ request()->is('login') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                       Sign In
                    </a>
                </li>
                <li>
                    <a href="{{ route('ticket.view.form') }}" class="bg-red-keloola text-white-primary px-4 py-2 rounded hover:bg-red-700 transition">View Ticket</a>
                </li>
            </ul>

            <!-- Hamburger button -->
            <button class="md:hidden text-black-keloola" id="mobile-menu-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6" id="hamburger-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 hidden" id="close-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden bg-white-primary border-t shadow-lg md:hidden">
            <div class="px-4 py-4 space-y-2 font-medium">
                <a href="{{ url('/') }}" 
                class="block py-2 px-4 rounded-md transition 
                {{ request()->is('/') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                Home
                </a>
                <a href="{{ url('/knowledge') }}" 
                class="block py-2 px-4 rounded-md transition 
                {{ request()->is('knowledge') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                Knowledge Base
                </a>
                <a href="{{ route('login') }}" 
                class="block py-2 px-4 rounded-md transition 
                {{ request()->is('login') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                Sign In
                </a>
                <div class="pt-2 border-t border-gray-200">
                    <a href="{{ route('ticket.view.form') }}" 
                    class="block bg-red-keloola text-white-primary px-4 py-2 rounded hover:bg-red-700 transition text-center font-medium">
                    View Ticket
                    </a>
                </div>
            </div>
        </div>


    </nav>

    @stack('scripts')
    @yield('content')
    @yield('scripts')

    <!-- JS -->
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="https://storage.keloola.com/ticket-thrive/livechat.js"></script>
</body>
</html>