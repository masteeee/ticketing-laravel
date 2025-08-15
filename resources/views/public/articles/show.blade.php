@extends('layouts.guest')

@section('content')
{{-- Bagian Search + Breadcrumb --}}
<section class="bg-search-section py-8">
    <div class="container mx-auto px-4">
        {{-- Search --}}
        <div class="relative">
            <div class="items-center space-x-4 hidden md:flex">
                <div class="relative flex-1">
                    <form method="GET" action="{{ route('knowledge.search') }}">
                        <input id="desktop-search-input" 
                               name="search"
                               type="text"
                               value="{{ request('search') }}"
                               placeholder="Search articles"
                               class="w-4/5 p-4 pr-32 border border-gray-primary outline-none">
                        <button id="desktop-search-dropdown"
                            class="absolute right-[20%] top-0 h-full px-4 rounded-r-lg flex items-center hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
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
                            <div class="flex space-x-2">
                                <div class="cursor-pointer hover:text-blue-primary transition-colors duration-200" title="Download as PDF" onclick="downloadAsPDF()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                </div>
                                {{-- Print --}}     
                                
                                <div class="cursor-pointer hover:text-green-600 transition-colors duration-200" title="Print Article" onclick="printArticle()">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.277-.457-1.336-1.107L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-1.086-.211M6.34 18H6.34m11.318 0H6.34" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Thumbnail --}}
                    @if($article->thumbnail)
                        <div class="w-full h-auto">
                            <img style="object-fit:cover;" src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="w-full h-auto">
                        </div>
                    @endif

                    {{-- Konten Artikel --}}
                    <div class="text-lg my-8 leading-relaxed article-content prose max-w-none">
                        {!! $article->content !!}
                    </div>

                    {{-- Related Articles --}}
                    @if($relatedArticles->count())
                    <h1 id="related-articles" class="text-red-keloola my-5 text-3xl font-medium">Related Articles</h1>
                    <div class="flex flex-col gap-y-2">
                        @foreach($relatedArticles as $related)
                            <a href="{{ route('public.articles.show', $related->slug) }}"
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
                                   class="flex items-start gap-2 text-black-keloola hover:text-blue-primary transition-colors duration-200 cursor-pointer scroll-to-section"
                                   data-target="{{ $heading['id'] }}">
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
                                <a href="{{ route('public.articles.show', $related->slug) }}"
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
@tailwind
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>


function downloadAsPDF() {
    // Get the article content and thumbnail
    const articleContent = document.querySelector('.article-content');
    const articleTitle = document.querySelector('h1').textContent;
    const thumbnailImg = document.querySelector('img[src*="storage"]');
    
    if (!articleContent) {
        alert('Article content not found!');
        return;
    }

    // Get thumbnail URL
    const thumbnailUrl = thumbnailImg ? thumbnailImg.src : null;
    
    // Create a new div for PDF content
    const pdfContent = document.createElement('div');
    pdfContent.innerHTML = `
        <div style="padding: 20px; font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto;">
            <h1 style="color: #dc2626; font-size: 24px; margin-bottom: 20px; border-bottom: 2px solid #dc2626; padding-bottom: 10px;">
                ${articleTitle}
            </h1>
            ${thumbnailUrl ? `<div style="text-align: center; margin-bottom: 20px;">
                <img src="${thumbnailUrl}" style="max-width: 100%; height: auto; max-height: 300px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" alt="Article Thumbnail">
            </div>` : ''}
            <div style="line-height: 1.6; font-size: 14px;">
                ${articleContent.innerHTML}
            </div>
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280;">
                <p>Generated from Keloola Knowledge Base</p>
                <p>Date: ${new Date().toLocaleDateString()}</p>
            </div>
        </div>
    `;

    // PDF options
    const opt = {
        margin: 1,
        filename: `${articleTitle.replace(/[^a-zA-Z0-9]/g, '_')}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };

    // Generate PDF
    html2pdf().set(opt).from(pdfContent).save();
}

function printArticle() {
    const articleContent = document.querySelector('.article-content');
    const articleTitle = document.querySelector('h1').textContent;
    const thumbnailImg = document.querySelector('img[src*="storage"]');
    
    if (!articleContent) {
        alert('Article content not found!');
        return;
    }

    const thumbnailUrl = thumbnailImg ? thumbnailImg.src : null;
    
    const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>${articleTitle}</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    line-height: 1.6; 
                    max-width: 800px; 
                    margin: 0 auto; 
                    padding: 20px;
                }
                h1 { 
                    color: #dc2626; 
                    font-size: 24px; 
                    margin-bottom: 20px; 
                    border-bottom: 2px solid #dc2626; 
                    padding-bottom: 10px;
                }
                .thumbnail-container {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .thumbnail-container img {
                    max-width: 100%;
                    height: auto;
                    max-height: 300px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }
                img { max-width: 100%; height: auto; }
                .print-footer { 
                    margin-top: 30px; 
                    padding-top: 20px; 
                    border-top: 1px solid #e5e7eb; 
                    font-size: 12px; 
                    color: #6b7280;
                }
                @media print {
                    body { margin: 0; padding: 15px; }
                    .thumbnail-container img {
                        max-height: 200px;
                    }
                }
            </style>
        </head>
        <body>
            <h1>${articleTitle}</h1>
            @if($article->thumbnail)
                <div class="thumbnail-container">
                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Article Thumbnail">
                </div>
            @endif
            <div class="article-content">${articleContent.innerHTML}</div>
            <div class="print-footer">
                <p>Generated from Keloola Knowledge Base</p>
                <p>Date: ${new Date().toLocaleDateString()}</p>
            </div>
        </body>
        </html>
    `;

    // Open print window
    const printWindow = window.open('', '_blank');
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.focus();
    
    // Wait for content to load then print
    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
}

// Smooth scroll functionality
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listeners to all scroll-to-section links
    const scrollLinks = document.querySelectorAll('.scroll-to-section');
    
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                // Smooth scroll to target
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Add highlight effect to target
                targetElement.style.transition = 'background-color 0.3s ease';
                targetElement.style.backgroundColor = '#fef3c7';
                
                // Remove highlight after 2 seconds
                setTimeout(() => {
                    targetElement.style.backgroundColor = '';
                }, 2000);
                
                // Update URL hash without jumping
                history.pushState(null, null, '#' + targetId);
            } else {
                console.log('Target element not found:', targetId);
            }
        });
    });
    
    // Handle direct URL hash navigation
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            setTimeout(() => {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                targetElement.style.transition = 'background-color 0.3s ease';
                // targetElement.style.backgroundColor = '#fef3c7';
                
                setTimeout(() => {
                    targetElement.style.backgroundColor = '';
                }, 2000);
            }, 100);
        }
    }
});
</script>
<style>
    .article-content img {
        max-width: 100% !important;
        height: auto !important;
        width: auto !important;
        display: block;
        margin-left: auto;
        margin-right: auto;
        object-fit: contain;
    }
    
    .article-content {
        overflow-wrap: break-word;
        word-wrap: break-word;
    }
    
    /* Ensure all media elements are responsive */
    .article-content video,
    .article-content iframe,
    .article-content embed,
    .article-content object {
        max-width: 100% !important;
        height: auto !important;
    }
</style>


@endsection
