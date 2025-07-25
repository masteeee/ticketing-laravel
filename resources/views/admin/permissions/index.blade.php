@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Permission</h1>
    <a href="{{ route('admin.permissions.create') }}" class="btn btn-danger mb-3">+ Tambah Permission</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>
                    <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-warning btn-sm m-2">Edit</a>
                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $permissions->links() }}
</div>
@endsection 