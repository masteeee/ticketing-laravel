@extends('layouts.guest')

@section('content')

@php
    use Illuminate\Support\Str;

    // Hitung total artikel pada kategori & turunannya
    function totalArticlesView($cat) {
        $count = ($cat->articles ?? collect())->count();
        foreach (($cat->children ?? collect()) as $child) {
            $count += totalArticlesView($child);
        }
        return $count;
    }

    // Cari artikel pertama dari kategori & turunannya
    function firstArticleView($cat) {
        if (($cat->articles ?? collect())->count() > 0) return $cat->articles->first();
        foreach (($cat->children ?? collect()) as $child) {
            $a = firstArticleView($child);
            if ($a) return $a;
        }
        return null;
    }

    // Breadcrumbs rekursif
    function breadcrumbs($category, $items = []) {
        if (!$category) return $items;
        array_unshift($items, $category);
        if ($category->parent) {
            return breadcrumbs($category->parent, $items);
        }
        return $items;
    }

    // Buat breadcrumbs jika sedang ada kategori
    $breadcrumbs = [];
    if (isset($currentCategory) && $currentCategory) {
        $breadcrumbs = breadcrumbs($currentCategory);
    }
@endphp
<section class="bg-search-section py-8">
    <div class="container mx-auto px-4">
        {{-- Search --}}
        <div class="relative">
            <div class="items-center space-x-4 hidden md:flex">
                <div class="relative flex-1">
                    <form method="GET" action="{{ route('knowledge.base') }}">
                        <input id="desktop-search-input" 
                               name="search"
                               type="text"
                               value="{{ request('search') }}"
                               placeholder="Search articles"
                               class="w-4/5 p-4 pr-32 border border-gray-primary outline-none">
                        <button id="desktop-search-dropdown"
                                class="absolute right-[20%] top-0 h-full px-4 rounded-r-lg flex items-center hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </form>
                    {{-- Dropdown search (opsional AJAX) --}}
                    <ul id="desktop-search-menu"
                        class="absolute hidden right-[15%] mt-1 w-48 bg-white-primary shadow-md rounded-md z-50"></ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Breadcrumb --}}
    <div class="container mx-auto px-4 py-4">
        <div class="text-sm text-primary">
            <a href="{{ route('knowledge.base') }}" class="text-primary lg:inline hidden">Knowledge Base</a>

        </div>
    </div>
</section>
<section class="bg-form-section py-10">
    <div class="container mx-auto px-4">
        {{-- SECTIONS jika kategori punya children --}}
        @if(isset($currentCategory) && $currentCategory && ($categories?->count() ?? 0) > 0)
            <h2 class="text-lg font-semibold mb-4">Sections</h2>
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mb-10">
                @foreach($categories as $cat)
                    @php
                        $total = totalArticlesView($cat);
                        $first = firstArticleView($cat);
                        $goUrl = ($total === 1 && $first)
                            ? route('public.articles.show', $first->id)
                            : route('knowledge.category', ['category' => $cat->id]);
                        $icon = asset('assets/keloola-logo.png');
                    @endphp

                    <a href="{{ $goUrl }}" class="bg-white-primary shadow rounded-lg p-6 block hover:shadow-md transition">
                        <div class="flex flex-wrap border-b border-card-bor-keloola pb-3">
                            <img src="{{ $icon }}" alt="{{ $cat->name }}" class="w-10 h-10 object-contain mr-3">
                            <h3 class="text-lg font-semibold">{{ $cat->name }}</h3>
                        </div>
                        <p class="text-black-keloola my-4">
                            {{ $cat->description ?? "Explore articles in {$cat->name}" }}
                        </p>
                        <div class="mt-20 flex gap-x-5 text-icon-breadcrumb">
                            <span>{{ $total }} Articles</span>
                            <span>{{ ($cat->children ?? collect())->count() }} Sections</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Articles di halaman kategori --}}
        @if(isset($currentCategory) && $currentCategory)
            <h2 class="text-lg font-semibold mb-4">Articles in {{ $currentCategory->name }}</h2>
            @if(($articles?->count() ?? 0) > 0)
                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                    @foreach($articles as $article)
                        <a href="{{ route('public.articles.show', $article->id) }}"
                           class="bg-white-primary p-6 rounded-lg shadow hover:shadow-md transition block">
                            <div class="flex items-start">
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/'.$article->thumbnail) }}" alt="{{ $article->title }}"
                                         class="w-16 h-16 object-cover rounded mr-3">
                                @endif
                                <div>
                                    <h3 class="font-semibold text-base mb-1">{{ $article->title }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ Str::limit(strip_tags($article->excerpt ?? $article->content ?? ''), 120) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white-primary rounded-lg p-6 shadow">
                    <p>Tidak ada artikel pada kategori ini.</p>
                </div>
            @endif
        @else
            {{-- ROOT: kategori utama --}}
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6">
                @forelse($categories as $cat)
                    @php
                        $total = totalArticlesView($cat);
                        $first = firstArticleView($cat);
                        $goUrl = ($total === 1 && $first)
                            ? route('articles.show', $first->id)
                            : route('knowledge.category', ['category' => $cat->id]);
                        $icon = asset('assets/keloola-logo.png');
                    @endphp
                    <a href="{{ $goUrl }}" class="bg-white-primary shadow rounded-lg p-6 block hover:shadow-md transition">
                        <div class="flex flex-wrap border-b border-card-bor-keloola pb-3">
                            <img src="{{ $icon }}" alt="{{ $cat->name }}" class="w-10 h-10 object-contain mr-3">
                            <h3 class="text-lg font-semibold">{{ $cat->name }}</h3>
                        </div>
                        <p class="text-black-keloola my-4">Explore articles in {{ $cat->name }}</p>
                        <div class="mt-20 flex gap-x-5 text-icon-breadcrumb">
                            <span>{{ $total }} Articles</span>
                            <span>{{ ($cat->children ?? collect())->count() }} Sections</span>
                        </div>
                    </a>
                @empty
                    <div class="bg-white-primary rounded-lg p-6 shadow text-center">
                        <p class="text-black-keloola">Tidak ada kategori tersedia.</p>
                    </div>
                @endforelse
            </div>
        @endif

        {{-- Recent & Popular --}}
        <div class="mt-10">
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-x-10 gap-y-10">
                <div>
                    <h3 class="font-bold text-lg text-left mb-4">Recent Articles</h3>
                    <div class="bg-white-primary border border-card-bor-keloola rounded-lg">
                        <ul class="flex flex-col">
                            @forelse($recentArticles as $article)
                                <li class="py-5 px-5 border-b last:border-0 border-card-bor-keloola hover:text-blue-primary">
                                    <a href="{{ route('public.articles.show', $article->id) }}">{{ $article->title }}</a>
                                </li>
                            @empty
                                <li class="py-5 px-5">Tidak ada artikel terbaru.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-left mb-4">Popular Articles</h3>
                    <div class="bg-white-primary border border-card-bor-keloola rounded-lg">
                        <ul class="flex flex-col">
                            @forelse($popularArticles as $article)
                                <li class="py-5 px-5 border-b last:border-0 border-card-bor-keloola hover:text-blue-primary">
                                    <a href="{{ route('public.articles.show', $article->id) }}">{{ $article->title }}</a>
                                </li>
                            @empty
                                <li class="py-5 px-5">Tidak ada artikel populer.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@include('layouts.footer')
@endsection
