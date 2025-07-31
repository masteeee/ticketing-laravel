@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-xl font-bold mb-4">Tambah Artikel</h1>

        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label fw-semibold">Judul</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Kategori</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label fw-semibold">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label fw-semibold">Konten</label>
                <textarea id="summernote" name="content" class="form-control"></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-danger">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(function () {
        $('#summernote').summernote({
            placeholder: 'Tulis konten artikel di sini...',
            tabsize: 2,
            height: 300
        });
    });
</script>
@endpush
