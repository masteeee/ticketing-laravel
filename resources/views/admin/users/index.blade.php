@extends('layouts.admin') 
@section('content')
<div class="container">
    <h1 class="mb-4">User List</h1>

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-danger">Add User</a>
    </div>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ? $user->role->name : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
