@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Permission</h1>
    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Permission</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-danger">Simpan</button>
    </form>
</div>
@endsection 