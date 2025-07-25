@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Artikel</h1>

    <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $cat->id == $article->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>     
        <div class="mb-3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
        </div>
        @if ($article->thumbnail)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" style="max-height: 150px;">
            </div>
        @endif
        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            <input id="content" type="hidden" name="content" value="{{ $article->content }}">
            <trix-editor input="content"></trix-editor>
        </div>
   
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
<script>
$(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        callbacks: {
            onImageUpload: function(files) {
                sendFile(files[0]);
            }
        }
    });
});

function sendFile(file) {
    let data = new FormData();
    data.append("image", file);
    $.ajax({
        url: "{{ route('admin.articles.upload-image') }}", // pastikan route ini tersedia
        method: "POST",
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: data,
        contentType: false,
        processData: false,
        success: function(url) {
            $('#summernote').summernote('insertImage', url);
        },
        error: function(err) {
            alert("Gagal upload gambar.");
        }
    });
}
</script>