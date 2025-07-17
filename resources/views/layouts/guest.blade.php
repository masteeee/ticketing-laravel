
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Keloola')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Tambahkan link ke CSS Tailwind atau file lainnya jika perlu --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-white-primary text-black-keloola">

    {{-- Navbar --}}

        <nav class="bg-white-primary shadow">
    <nav class="bg-white-primary shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('assets/keloola-logo.png') }}" alt="Logo" class="w-20 h-20 object-contain">
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
                    <a href="#"
                       class="{{ request()->is('community') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                       Community
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}"
                       class="{{ request()->is('login') ? 'text-red-keloola' : 'text-black-keloola hover:text-red-keloola' }}">
                       Sign In
                    </a>
                <li class="relative ml-2">
                    <button id="font-button" class="text-black-keloola hover:text-red-keloola">A<sup>+</sup></button>
                    <div id="font-menu" class="absolute hidden mt-2 bg-white-primary shadow-md rounded-md p-2 z-50 right-0 w-max">
                    <h3 class="text-black-keloola mb-2">Font Size</h3>
                    <div class="flex items-center space-x-2 border border-gray-primary p-2 rounded">
                        <button id="decrease-font" class="bg-gray-primary px-2 py-1 rounded text-md hover:bg-gray-secondary">-</button>
                        <span id="font-size-display" class="px-2 py-1">16px</span>
                        <button id="increase-font" class="bg-gray-primary text-white px-2 py-1 rounded text-md hover:bg-gray-secondary">+</button>
                    </div>
                    <h3 class="text-black-keloola mt-4 mb-2">Layout</h3>
                              <div class="flex space-x-4">
                                   <button id="layout-1"
                                        class="border border-rgb-keloola rounded p-2 hover:bg-gray-secondary">
                                        <div class="w-10 h-10 bg-gray-primary"></div>
                                   </button>
                                   <button id="layout-2"
                                        class="border border-rgb-keloola rounded p-2 hover:bg-gray-secondary">
                                        <div class="w-10 h-10 bg-gray-primary"></div>
                                   </button>
                              </div>
                              <div class="flex justify-between items-center mt-4">
                                   <label class="text-sm text-black-keloola">Full Width</label>
                                   <div class="relative">
                                        <input type="checkbox" id="full-width-toggle" class="hidden">
                                        <label for="full-width-toggle" class="flex items-center cursor-pointer">
                                             <div
                                                  class="w-12 h-6 bg-gray-primary rounded-full transition-colors duration-200">
                                             </div>
                                             <div id="toggle-circle"
                                                  class="absolute w-4 h-4 bg-blue-primary rounded-full transform translate-x-1 transition-transform duration-200">
                                             </div>
                                        </label>
                                   </div>
                              </div>
                </div>
                </li>
                <li class="relative">
                    <button id="desktop-language-button" class="text-black-keloola text-sm hover:text-red-keloola flex items-center">
                        English <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="desktop-language-menu" class="absolute hidden mt-2 p-2 bg-white-primary shadow rounded-md text-sm z-50 right-0">
                        <li><a href="#" class="block px-4 py-2 hover:text-primary">English</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:text-primary">Spanish</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:text-primary">French</a></li>
                    </ul>
                </li>
            </ul>
            <button class="md:hidden text-black-keloola" id="mobile-menu-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- Konten Halaman --}}
    <main class="mt-6 container mx-auto px-4">
        @yield('content')
    </main>

</body>
</html>
