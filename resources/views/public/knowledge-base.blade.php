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
<div class="bg-orange-100 py-10 px-4">
    <div class="max-w-6xl mx-auto text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Knowledge Base</h1>
        <input type="text" placeholder="Cari artikel..." class="w-full md:w-1/2 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring" />
    </div>
</div>

<!-- Kategori -->
<div class="max-w-6xl mx-auto py-10">
    <h2 class="text-xl font-semibold mb-6">Kategori</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($categories as $category)
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                <h3 class="text-lg font-bold mb-2">{{ $category->name }}</h3>
                <p class="text-sm text-gray-600 mb-3">{{ $category->description }}</p>
                <ul class="text-sm list-disc pl-5 space-y-1">
                    @foreach($category->articles->take(3) as $article)
                        <li><strong>{{ $article->title }}</strong></li>
                    @endforeach
                </ul>
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
            <h2 class="text-xl font-semibold mb-4">Artikel Terbaru</h2>
            <ul class="bg-white p-6 rounded-lg shadow space-y-2">
                @forelse($recentArticles as $article)
                    <li class="border-b pb-2"><strong>{{ $article->title }}</strong></li>
                @empty
                    <li>Tidak ada artikel terbaru.</li>
                @endforelse
            </ul>
        </div>

        <!-- Artikel Populer -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Artikel Populer</h2>
            <ul class="bg-white p-6 rounded-lg shadow space-y-2">
                @forelse($popularArticles as $article)
                    <li class="border-b pb-2"><strong>{{ $article->title }}</strong> <span class="text-sm text-gray-500">({{ $article->views }} views)</span></li>
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
