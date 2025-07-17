@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Kategori</h1>

    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
