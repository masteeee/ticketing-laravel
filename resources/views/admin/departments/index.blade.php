@extends('layouts.admin')

@section('content')
<div class="container rounded p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-0">Departments</h2>
        <div>
            <button id="refresh-department" class="btn btn-info me-2">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createModal">
                + Add Department
            </button>
        </div>
    </div>

    <div class="table-responsive table-bordered">
        <table class="table table-bordered table-hover align-middle text-sm">
            <thead class="table-light">
                <tr class="text-black">
                    <th style="width: 5%;">No</th>
                    <th>Nama</th>
                    <th style="width: 120px;">Logo</th>
                    <th class="text-center" style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $key => $department)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $department->name }}</td>
                    <td>
                        @if($department->logo_url)
                            <img src="{{ asset('storage/' . $department->logo_url) }}" alt="Logo" width="60">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $department->id }}">
                            Edit
                        </button>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

                {{-- Edit Modal --}}
                <div class="modal fade" id="editModal{{ $department->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $department->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('departments.update', $department) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $department->id }}">Edit Department</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Department</label>
                                        <input type="text" name="name" class="form-control" value="{{ $department->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control">{{ $department->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Logo (opsional)</label>
                                        <input type="file" name="logo" class="form-control">
                                        @if($department->logo_url)
                                            <img src="{{ asset('storage/' . $department->logo_url) }}" alt="Logo" width="100" class="mt-2 rounded shadow-sm">
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $departments->links() }}
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Department</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo (opsional)</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('refresh-department').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin refresh department?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, refresh',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (!result.isConfirmed) return;
            fetch("{{ route('departments.refresh') }}", {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat refresh.' });
            });
        });
    });
</script>
@endsection
