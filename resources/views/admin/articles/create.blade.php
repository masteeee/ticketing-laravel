@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Artikel</h1>

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea id="summernote" name="content" class="form-control"></textarea>
        </div>



        <button class="btn btn-danger">Simpan</button>
    </form>
</div>
@endsection

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- jQuery (wajib sebelum Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<!-- Inisialisasi Summernote -->
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Tulis konten artikel di sini...',
            tabsize: 2,
            height: 300
        });
    });
    
</script>
@endpush
