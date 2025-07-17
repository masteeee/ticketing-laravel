@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Department</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.departments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Department</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" id="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo (opsional)</label>
            <input type="file" name="logo" class="form-control" id="logo">
        </div>

        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
