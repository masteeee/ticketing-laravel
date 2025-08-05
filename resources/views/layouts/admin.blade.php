<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keloola Admin</title>

    {{-- FontAwesome --}}
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    {{-- SB Admin Template --}}
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- TailwindCSS (CDN or compiled) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Rich text editor --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.min.css">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/2.0.0/trix.umd.min.js"></script>

    {{-- Summernote --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    {{-- Custom Style --}}
    <style>
        body {
            background-color: white !important;
        }

        .form-control {
            @apply px-3 py-2 border border-gray-300 rounded-lg w-full;
        }

        .btn {
            @apply px-4 py-2 rounded-lg font-medium;
        }

        .btn-primary {
            @apply bg-blue-600 text-white hover:bg-blue-700;
        }

        .btn-danger {
            @apply bg-red-600 text-white hover:bg-red-700;
        }

        .btn-sm {
            @apply px-2 py-1 text-sm;
        }

        table th, table td {
            @apply text-sm align-middle;
        }

        .card {
            @apply bg-white shadow-md rounded-xl p-4;
        }

        /* Notification styles */
        .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            margin-top: -0.25rem;
        }

        .icon-circle {
            height: 2rem;
            width: 2rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-list {
            max-width: 20rem !important;
        }

        .dropdown-list .dropdown-item {
            white-space: normal;
            border-left: 0.25rem solid #e3e6f0;
            border-bottom: 0.125rem solid #e3e6f0;
        }

        .dropdown-list .dropdown-item:hover {
            background-color: #eaecf4;
            color: #2e2f37;
        }
        .sidebar-keloola{
            color: white;
            background : #de342f;
        }
        .sidebar-keloola a{
            text-decoration: none;
            color: white;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-gray-800 min-h-screen">

    <div id="wrapper" class="flex">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div id="content-wrapper" class="flex-grow flex flex-col">

            {{-- Topbar --}}
            <div id="content">
                @include('layouts.topbar')

                {{-- Page Content --}}
                <main class="p-6 bg-white min-h-screen">
                    @yield('content')
                </main>
            </div>

            {{-- Footer --}}
            @include('layouts.footer-admin')
        </div>
    </div>

    {{-- Scripts --}}
    @include('layouts.scripts')
    @stack('scripts')
    @yield('scripts')

</body>
</html>
