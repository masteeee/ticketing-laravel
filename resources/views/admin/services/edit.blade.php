@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Service</h1>

    <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Service Name</label>
            <input type="text" class="form-control" name="name" value="{{ $service->name }}" required>
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <select name="department_id" class="form-control" required>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $dept->id == $service->department_id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-danger" type="submit">Update</button>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
