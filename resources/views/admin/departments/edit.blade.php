@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Department</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.departments.update', $department) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Department</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $department->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" id="description">{{ $department->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo (opsional)</label>
            <input type="file" name="logo" class="form-control" id="logo">
            @if($department->logo_url)
                <img src="{{ asset('storage/' . $department->logo_url) }}" alt="Logo" width="120" class="mt-2">
            @endif
        </div>

        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Kembali</a>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
