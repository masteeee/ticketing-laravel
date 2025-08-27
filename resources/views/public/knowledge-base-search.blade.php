@extends('layouts.guest')

@section('content')
<section class="bg-search-section py-8">
    <div class="container mx-auto px-4">
        {{-- Search --}}
        <div class="relative">
            {{-- Mobile search --}}
            <div class="md:hidden">
                <div class="relative">
                    <form method="GET" action="{{ route('knowledge.search') }}" class="w-full">
                        <div class="w-full flex items-center border border-gray-primary rounded-lg overflow-hidden">
                            <input id="mobile-search-input" 
                                   name="search"
                                   type="text"
                                   value="{{ request('search') }}"
                                   placeholder="Search articles"
                                   class="flex-1 px-4 py-3 outline-none border-0 focus:ring-0">
                            <button type="submit" aria-label="Search" id="mobile-search-button" style="background: white"
                                    class="px-4 py-3 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <ul id="mobile-search-menu" class="absolute hidden left-0 mt-1 w-full bg-white-primary shadow-md rounded-md z-50"></ul>
                </div>
            </div>

            {{-- Desktop search --}}
            <div class="items-center space-x-4 hidden md:flex">
                <div class="relative flex-1">
                    <form method="GET" action="{{ route('knowledge.search') }}" class="w-full">
                        <div class="w-full flex items-center border border-gray-primary rounded-lg overflow-hidden">
                            <input id="desktop-search-input" 
                                   name="search"
                                   type="text"
                                   value="{{ request('search') }}"
                                   placeholder="Search articles"
                                   class="flex-1 px-4 py-4 outline-none border-0 focus:ring-0">
                            <button type="submit" aria-label="Search" id="desktop-search-button" style="background: white"
                                    class="px-4 py-4 text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    {{-- Dropdown search (opsional AJAX) --}}
                    <ul id="desktop-search-menu"
                        class="absolute hidden left-0 mt-1 w-full bg-white-primary shadow-md rounded-md z-50"></ul>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="bg-form-section py-5">
    <div class="departments-container container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- LEFT: Card Artikel + Sections --}}
            <div class="lg:w-3/4 bg-white-primary border border-section-bor rounded-md">
                <div class="p-4">

                    {{-- Articles --}}
                    @if($articles->count())
                        <h2 class="text-xl font-semibold mb-4">Articles</h2>
                        <ul class="space-y-4 mb-8">
                            @foreach($articles as $article)
                                <li>
                                    <a href="{{ route('public.articles.show', [
                                        'bulan' => $article->created_at->format('m'),
                                        'tahun' => $article->created_at->format('Y'),
                                        'slug' => $article->slug
                                    ]) }}"
                                       class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mt-1 flex-shrink-0"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                                        </svg>
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $article->title }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?? $article->content), 120) }}
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="lg:w-1/4">
                {{-- Info --}}
                    <div class="bg-white-primary border border-section-bor rounded-md p-4">
                        <h2 class="text-xl font-semibold">Search Result</h2>
                        <p class="text-sm my-2 text-gray-600">
                            {{ $articles->count() }} articles found for "{{ request('search') }}"
                        </p>
                    </div>

                {{-- Popular --}}
                <div class="mt-5">
                    <h2 class="text-xl font-semibold mb-4">Popular Articles</h2>
                    <ul class="space-y-3">
                        @foreach($popularArticles as $article)
                            <li>
                                <a href="{{ route('public.articles.show', $article->slug) }}"
                                   class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                                    </svg>
                                    <span>{{ $article->title }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Recent --}}
                <div class="mt-5">
                    <h2 class="text-xl font-semibold mb-4">Recent Articles</h2>
                    <ul class="space-y-3">
                        @foreach($recentArticles as $article)
                            <li>
                                <a href="{{ route('public.articles.show', $article->slug) }}"
                                   class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                                    </svg>
                                    <span>{{ $article->title }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

@include('layouts.footer')
@endsection
