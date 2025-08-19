@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Daftar Artikel</h1>
        <a href="{{ route('articles.create') }}" class="btn btn-danger">+ Tambah Artikel</a>
    </div>

    {{-- Search and Filter Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('articles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label fw-semibold text-gray-700 mb-1 text-sm">
                        <i class="fas fa-search me-1 text-red-600"></i>Cari Artikel
                    </label>
                    <input type="text" 
                           name="search" 
                           id="search" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white shadow-sm hover:shadow-md text-sm" 
                           placeholder="Cari judul atau konten..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="category_id" class="form-label fw-semibold text-gray-700 mb-1 text-sm">
                        <i class="fas fa-filter me-1 text-blue-600"></i>Filter Kategori
                    </label>
                    <select name="category_id" id="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white shadow-sm hover:shadow-md text-sm">
                        <option value="" class="text-gray-500">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    class="text-gray-800" 
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label fw-semibold text-gray-700 mb-1 text-sm">
                        <i class="fas fa-sort me-1 text-green-600"></i>Urutkan
                    </label>
                    <select name="sort" id="sort" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-white shadow-sm hover:shadow-md text-sm">
                        <option value="latest" class="text-gray-800" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                            <i class="fas fa-clock me-1"></i>Terbaru
                        </option>
                        <option value="oldest" class="text-gray-800" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                            <i class="fas fa-history me-1"></i>Terlama
                        </option>
                        <option value="title_asc" class="text-gray-800" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                            <i class="fas fa-sort-alpha-down me-1"></i>Judul A-Z
                        </option>
                        <option value="title_desc" class="text-gray-800" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                            <i class="fas fa-sort-alpha-up me-1"></i>Judul Z-A
                        </option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all duration-200 font-medium flex-fill flex items-center justify-center text-sm">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="{{ route('articles.index') }}" class="px-3 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-all duration-200 font-medium flex-fill flex items-center justify-center text-sm">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm rounded">{{ session('error') }}</div>
    @endif

    {{-- Search Results Info --}}
    @if(request('search') || request('category_id') || request('sort'))
        <div class="alert alert-info shadow-sm rounded mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Hasil Pencarian:</strong>
                    @if(request('search'))
                        <span class="badge bg-primary ms-2">"{{ request('search') }}"</span>
                    @endif
                    @if(request('category_id'))
                        <span class="badge bg-success ms-2">{{ $categories->find(request('category_id'))->name ?? 'Kategori' }}</span>
                    @endif
                    @if(request('sort'))
                        <span class="badge bg-warning ms-2">{{ ucfirst(str_replace('_', ' ', request('sort'))) }}</span>
                    @endif
                </div>
                <div>
                    <span class="text-muted">{{ $articles->total() }} artikel ditemukan</span>
                </div>
            </div>
        </div>
    @endif

    <div class="card rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-black">
                        <th class="border text-left">Judul</th>
                        <th class="border text-center">Kategori</th>
                        <th class="border text-center">Thumbnail</th>
                        <th class="border text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($articles as $article)
                    <tr class="transition hover:bg-gray-100">
                        <td class="border fw-semibold align-middle">{{ $article->title }}</td>
                        <td class="border align-middle text-center">{{ $article->category->name }}</td>
                        <td class="border align-middle text-center">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="thumb" class="rounded mx-auto" style="height: 40px;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="border text-center">
                            <a href="{{ route('articles.edit', $article->slug) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="{{ route('articles.destroy', $article->slug) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted border">Belum ada artikel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection
