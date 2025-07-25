@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Artikel</h1>

    <a href="{{ route('admin.articles.create') }}" class="btn btn-danger mb-3">+ Tambah Artikel</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Aksi</th>
                <th>Thumbnail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->category->name }}</td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
                <td>
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="" style="max-height: 50px;">
                    @else
                        Tidak ada
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $articles->links() }}
</div>
@endsection
