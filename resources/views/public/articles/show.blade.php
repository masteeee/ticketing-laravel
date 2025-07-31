@extends('layouts.guest')

@section('content')
{{-- Bagian Search + Breadcrumb --}}
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
            @if($article->category)
                <span class="mx-2 text-icon-breadcrumb lg:inline hidden">/</span>
                @foreach($breadcrumbs as $crumb)
                    @if(!$loop->last)
                        <a href="{{ route('knowledge.category', ['category' => $crumb->id]) }}"
                           class="text-primary hover:underline">
                            {{ $crumb->name }}
                        </a>
                        <span class="mx-2 text-icon-breadcrumb">/</span>
                    @else
                        <span class="text-icon-breadcrumb">{{ $crumb->name }}</span>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- Artikel Detail --}}
<section class="bg-form-section py-5">
    <div class="departments-container container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Kiri: Isi Artikel --}}
            <div class="flex flex-wrap justify-between p-4 lg:w-3/4 bg-white-primary rounded-md">
                <div class="w-full">
                    {{-- Judul + Aksi --}}
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-3xl font-bold text-black-keloola">{{ $article->title }}</h1>
                        <div class="flex gap-4">
                            {{-- PDF Download --}}
                            <div class="cursor-pointer hover:text-blue-primary" title="Download as PDF">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            {{-- Print --}}
                            <div class="cursor-pointer hover:text-blue-primary" title="Print"
                                 onclick="window.print()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171..." />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Konten Artikel --}}
                    <div class="text-lg my-8 leading-relaxed article-content prose max-w-none">
                        {!! $article->content !!}
                    </div>

                    {{-- Related Articles --}}
                    @if($relatedArticles->count())
                    <h1 id="related-articles" class="text-red-keloola my-5 text-3xl font-medium">Related Articles</h1>
                    <div class="flex flex-col gap-y-2">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('public.articles.show', $related->id) }}"
                               class="text-base text-primary">
                                {{ $related->title }}
                            </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Kanan: Sidebar --}}
            <div class="lg:w-1/4 space-y-6 h-[calc(100vh-200px)] sticky top-24 overflow-y-scroll">
                {{-- Follow --}}
                <div>
                    <button class="w-1/2 h-8 my-5 font-medium rounded-md border border-blue-primary text-black-keloola hover:bg-blue-primary hover:text-white-primary">
                        Follow
                    </button>
                    <div class="text-sm">Subscribe to receive notifications from this article.</div>
                </div>

                {{-- Overview: daftar heading artikel --}}
                <div>
                    <h2 class="text-xl font-semibold mb-4">On this page</h2>
                    <ul class="space-y-4">
                        @foreach($headings as $heading)
                            <li>
                                <a href="#{{ $heading['id'] }}" 
                                   class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                    {{ $heading['text'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Related Sidebar --}}
                <div>
                    <h2 class="text-xl font-semibold mb-4">Related Articles</h2>
                    <ul class="space-y-2">
                        @foreach($relatedArticles as $related)
                            <li>
                                <a href="{{ route('public.articles.show', $related->id) }}"
                                   class="flex items-start gap-2 text-black-keloola hover:text-blue-primary">
                                   {{ $related->title }}
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
