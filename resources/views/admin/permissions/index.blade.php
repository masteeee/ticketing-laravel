@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Daftar Permission</h1>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addPermissionModal">+ Tambah Permission</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered bg-white rounded shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th class="text-center" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td class="d-flex gap-2 justify-center">
                        <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editPermissionModal"
                            data-id="{{ $permission->id }}"
                            data-name="{{ $permission->name }}">
                            Edit
                        </button>
                        <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
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
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="permission_name" class="form-label">Nama Permission</label>
                    <input type="text" name="name" id="permission_name" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" id="editPermissionForm">
            @csrf @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label for="edit_name" class="form-label">Nama Permission</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Script: Populate Edit Modal -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editModal = document.getElementById('editPermissionModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');

        const form = editModal.querySelector('#editPermissionForm');
        form.action = `/admin/permissions/${id}`;
        form.querySelector('#edit_id').value = id;
        form.querySelector('#edit_name').value = name;
    });
});
</script>
@endsection
