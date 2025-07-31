@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">User List</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-danger rounded shadow px-4 py-2">+ Add User</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow rounded overflow-hidden">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="whitespace-nowrap">Name</th>
                        <th class="whitespace-nowrap">Email</th>
                        <th class="whitespace-nowrap">Role</th>
                        <th class="text-center whitespace-nowrap" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="align-middle">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role ? $user->role->name : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
