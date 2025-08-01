@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Daftar Role</h1>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-danger">+ Tambah Role</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card rounded bg-white">
        <div class="card-body p-0">
            <div class="table-responsive table-bordered">
                <table class="table table-bordered mb-0">
                    <thead class="table-light table-bordered">
                        <tr class="text-black">
                            <th>No</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $role->name }}</td>
                            <td class="align-middle">
                                @foreach($role->permissions as $perm)
                                    <span class="badge bg-danger text-light me-1 mb-1">{{ $perm->name }}</span>
                                @endforeach
                            </td>
                            <td class="align-middle text-nowrap">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $roles->links() }}
    </div>
</div>
@endsection
