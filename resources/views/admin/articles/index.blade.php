@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Daftar Artikel</h1>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-danger">+ Tambah Artikel</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm rounded overflow-hidden">
        <div class="table-responsive table-bordered">
            <table class="table table-bordered table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border text-center">Judul</th>
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
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus artikel ini?')">
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
