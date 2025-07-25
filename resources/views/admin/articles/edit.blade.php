@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Artikel</h1>

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $article->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label><br>
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" width="120" class="mb-2"><br>
                    @endif
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
         </div>
        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <textarea id="summernote" name="content" class="form-control">{!! $article->content !!}</textarea>
        </div>

        

        <button class="btn btn-danger">Update</button>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Edit konten artikel...',
            tabsize: 2,
            height: 300
        });
    });
</script>
@endpush
