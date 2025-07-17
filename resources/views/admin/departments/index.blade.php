@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Departments</h2>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-danger mb-3">Add Department</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                    <button id="refreshButton"
                        class="btn btn-info btn-sm">Refresh
                    </button>
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
</div>
@endsection
<script>
    document.getElementById('refreshButton').addEventListener('click', function () {
        const alertContainer = document.getElementById('alertContainer');

        fetch("{{ route('admin.departments.refresh') }}", {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Tampilkan alert sesuai status
            const alert = document.createElement('div');
            alert.className = 'p-3 rounded mt-2';
            if (data.success) {
                alert.classList.add('bg-green-100', 'text-green-800');
                alert.innerText = data.message;
            } else {
                alert.classList.add('bg-red-100', 'text-red-800');
                alert.innerText = data.message || 'Terjadi kesalahan saat memperbarui.';
            }

            alertContainer.innerHTML = '';
            alertContainer.appendChild(alert);

            // TODO: Panggil fungsi untuk reload tabel department (jika ingin dinamis)
            // loadDepartments(); // <- bisa kamu buat jika tabel dinamis
        })
        .catch(error => {
            console.error(error);
            alertContainer.innerHTML = `
                <div class="bg-red-100 text-red-800 p-3 rounded mt-2">
                    Terjadi kesalahan AJAX.
                </div>`;
        });
    });
</script>
