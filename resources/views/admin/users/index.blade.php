@extends('layouts.admin') 

@section('content')
<div class="container">
    <h1 class="mb-4 text-dark">User List</h1>

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-danger">Add User</a>
    </div>

    <table class="table table-bordered" style="background-color: rgba(255, 255, 255, 0.5);">
        <thead style="background-color: rgba(255, 255, 255, 0.8);" class="text-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="text-dark">
            @forelse($users as $user)
            <tr style="background-color: rgba(255, 255, 255, 0.3);">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ? $user->role->name : '-' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr style="background-color: rgba(255, 255, 255, 0.3);">
                <td colspan="4">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
