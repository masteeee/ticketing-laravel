@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Permission</h1>
    <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Permission</label>
            <input type="text" name="name" class="form-control" value="{{ $permission->name }}" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection 