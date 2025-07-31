@extends('layouts.guest')

@section('content')
<div class="container mx-auto px-4 py-4">
    {{-- Search (paling atas) --}}
    <form method="GET" action="{{ route('knowledge.category') }}"
          class="relative w-full max-w-md mb-2">
        <input type="hidden" name="category" value="{{ $category->id }}">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search articles"
            class="w-full p-2 pr-10 border border-gray-primary rounded-md outline-none focus:ring"
        >
        <button type="submit"
                class="absolute right-0 top-0 h-full px-3 flex items-center rounded-r-md hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </form>

    {{-- Breadcrumb (di bawah search) --}}
    <div class="text-sm text-primary mb-4 flex gap-1">
        <a href="{{ route('knowledge.base') }}" class="text-primary hover:underline">Knowledge Base</a>
        @foreach($breadcrumbs as $crumb)
            <span>/</span>
            @if(!$loop->last)
                <a href="{{ route('knowledge.category', ['category' => $crumb->id]) }}" class="text-primary hover:underline">
                    {{ $crumb->name }}
                </a>
            @else
                <span class="text-icon-breadcrumb">{{ $crumb->name }}</span>
            @endif
        @endforeach
    </div>
</div>

<section class="bg-form-section py-5">
    <div class="departments-container container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- LEFT: Card Artikel + Sections --}}
            <div class="lg:w-3/4 bg-white-primary border border-section-bor rounded-md">
                <div class="p-4">

                    {{-- Articles --}}
                    @if($articles->count())
                        <ul class="space-y-4 mb-8">
                            @foreach($articles as $article)
                                <li>
                                    <a href="{{ route('public.articles.show', $article->id) }}"
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

                    {{-- Sub Categories --}}
                    @if($category->children->count())
                        <ul class="space-y-4">
                            @foreach($category->children as $child)
                                @php
                                    $articleCount = $child->articles->count();
                                    $sectionCount = $child->children->count();
                                    $url = ($articleCount === 1 && $sectionCount === 0)
                                        ? route('public.articles.show', $child->articles->first()->id)
                                        : route('knowledge.category', ['category' => $child->id]);
                                @endphp
                                <li>
                                    <a href="{{ $url }}" class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1 flex-shrink-0"
                                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                                        </svg>
                                        <div class="flex flex-col">
                                            <h2 class="text-lg font-semibold">{{ $child->name }}</h2>
                                            <div class="flex gap-x-5 text-sm my-2 text-gray-600">
                                                <p>{{ $articleCount }} Articles</p>
                                                <p>{{ $sectionCount }} Sections</p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @elseif(!$articles->count())
                        <p class="text-gray-600">No articles or sections available in this category.</p>
                    @endif

                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="lg:w-1/4">
                {{-- Info --}}
                <div class="bg-white-primary border border-section-bor rounded-md p-4">
                    <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
                    <p class="text-sm my-2 text-gray-600">
                        {{ $category->description ?? 'Learn more from the resources in this section.' }}
                    </p>
                    <button class="w-full h-8 my-3 font-medium rounded-md border border-blue-primary text-black-keloola hover:bg-blue-primary hover:text-white-primary">
                        Follow
                    </button>
                    <p class="text-sm text-gray-500">Subscribe to receive notifications from this section.</p>
                </div>

                {{-- Popular --}}
                <div class="mt-5">
                    <h2 class="text-xl font-semibold mb-4">Popular Articles</h2>
                    <ul class="space-y-3">
                        @foreach($popularArticles as $article)
                            <li>
                                <a href="{{ route('public.articles.show', $article->id) }}"
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
                                <a href="{{ route('public.articles.show', $article->id) }}"
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
