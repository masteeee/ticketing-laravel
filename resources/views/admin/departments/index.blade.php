@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Departments</h2>
    <div class="d-flex justify-content-between mb-3">
        <button id="refresh-department" class="btn btn-info">
            <i class="fas fa-sync-alt"></i>
        </button>
        <a href="{{ route('admin.departments.create') }}" class="btn btn-danger">Add Department</a>
    </div>
    
                    <!-- SweetAlert CDN -->
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
                                fetch("{{ route('admin.departments.refresh') }}", {
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
                                            window.location = window.location.pathname + '?refreshed=1';
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: data.message
                                        });
                                    }
                                })
                                .catch(err => {
                                    console.error(err);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan saat melakukan refresh.'
                                    });
                                });
                            });
                        });
                    </script>
    @if(session('success') && !request('refreshed'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $key => $department)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $department->name }}</td>
                <td>
                    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-warning btn-sm">Edit</a>
                  
                    <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                        <div id="alertContainer" class="mt-4"></div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $departments->links() }}
</div>
@endsection
