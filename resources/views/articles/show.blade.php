@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white p-8 rounded shadow p-4">
            <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
            <div class="mb-4 text-sm text-gray-500">
                Kategori: {{ $article->category->name ?? '-' }}
            </div>
            <div class="prose max-w-none mb-6">{!! nl2br(e($article->content)) !!}</div>
            @if($article->creator)
                <div class="text-xs text-gray-400">Ditulis oleh: {{ $article->creator->name }}</div>
            @endif
        </div>
    </div>
</div>
@endsection 