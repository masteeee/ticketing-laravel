@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-4 py-4">
    <div class="text-sm text-primary mb-4 flex gap-1">
        <a href="{{ route('knowledge.base') }}" class="text-primary hover:underline">Knowledge Base</a>
        @foreach($breadcrumbs as $crumb)
            <span>/</span>
            <a href="{{ route('knowledge.category', ['category' => $crumb->id]) }}" class="text-primary hover:underline">
                {{ $crumb->name }}
            </a>
        @endforeach
        <span>/</span>
        <span class="text-icon-breadcrumb">{{ $article->title }}</span>
    </div>
</div>
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white p-8 rounded shadow p-4">
            <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
            <div class="mb-4 text-sm text-gray-500">
                Kategori: {{ $article->category->name ?? '-' }}
            </div>
            <div class="article-content prose max-w-none mb-6">
                <div class="[&>img]:mx-auto [&>img]:max-w-[600px] [&>img]:rounded-lg">
                    {!! $article->content !!}
                </div>
            </div>
            @if($article->creator)
                <div class="text-xs text-gray-400">Ditulis oleh: {{ $article->creator->name }}</div>
            @endif
        </div>
    </div>
</div>
@endsection 