<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('dist/css/output.css') }}">
    </head>
    <body class="bg-gray-parent">
@extends('layouts.guest')

@section('content')
<!-- Header dan Search -->
<div class="bg-orange-50 py-10 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Knowledge Base</h1>
        <div class="flex justify-center">
            <input type="text" placeholder="Search articles" class="w-full max-w-xl border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring" />
        </div>
    </div>
</div>

<!-- Kategori -->
<div class="max-w-6xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-700">Knowledge Base</h2>
        <div class="flex space-x-2">
            <button class="bg-white border border-gray-300 px-4 py-2 rounded shadow hover:shadow-md text-sm text-gray-700">➕ Add Request</button>
            <button class="bg-white border border-gray-300 px-4 py-2 rounded shadow hover:shadow-md text-sm text-gray-700">➕ Add Topic</button>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($categories as $category)
            <div class="bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                <div class="flex items-center space-x-3 mb-2">
                    <img src="{{ $category->icon ?? 'https://via.placeholder.com/24' }}" class="w-6 h-6" alt="icon-{{ Str::slug($category->name) }}">
                    <h3 class="text-base font-semibold">{{ $category->name }}</h3>
                </div>
                <p class="text-sm text-gray-600 mb-3">{{ $category->description }}</p>
                <div class="text-xs text-gray-500">
                    {{ $category->articles->count() }} Articles &nbsp; | &nbsp;
                    {{ $category->sections_count ?? rand(1, 30) }} Sections
                </div>
            </div>
        @empty
            <p>Tidak ada kategori tersedia.</p>
        @endforelse
    </div>
</div>

<!-- Artikel Terbaru & Populer -->
<div class="bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Artikel Terbaru -->
        <div>
            <h2 class="text-md font-semibold mb-4">Recent Articles</h2>
            <ul class="bg-white p-6 rounded-lg shadow space-y-2 text-sm">
                @forelse($recentArticles as $article)
                    <li class="border-b pb-2">{{ $article->title }}</li>
                @empty
                    <li>Tidak ada artikel terbaru.</li>
                @endforelse
            </ul>
        </div>

        <!-- Artikel Populer -->
        <div>
            <h2 class="text-md font-semibold mb-4">Popular Articles</h2>
            <ul class="bg-white p-6 rounded-lg shadow space-y-2 text-sm">
                @forelse($popularArticles as $article)
                    <li class="border-b pb-2">{{ $article->title }}</li>
                @empty
                    <li>Tidak ada artikel populer.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('dist/js/app.js') }}"></script>
</body>
</html>
