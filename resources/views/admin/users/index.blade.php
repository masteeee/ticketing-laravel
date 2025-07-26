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
            </tr>
        </thead>
        <tbody class="text-dark">
            @forelse($users as $user)
            <tr style="background-color: rgba(255, 255, 255, 0.3);">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ? $user->role->name : '-' }}</td>
            </tr>
            @empty
            <tr style="background-color: rgba(255, 255, 255, 0.3);">
                <td colspan="3">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
