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

        {{-- Nama Department --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Department</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" id="description" rows="4"></textarea>
        </div>

        {{-- Upload Logo --}}
        <div class="mb-3">
            <label for="logo_url" class="form-label">Upload Logo</label>
            <input type="file" name="logo_url" class="form-control" id="logo" accept="image/*">
            <small class="form-text text-muted">Format gambar: JPG, PNG, dll. Max: 2MB.</small>
        </div>

        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
