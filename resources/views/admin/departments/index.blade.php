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
                    <button id="refresh-department"
                        class="btn btn-info btn-sm">Refresh
                    </button>
                    <script>
                        document.getElementById('refresh-department').addEventListener('click', function () {
                            if (!confirm("Yakin ingin refresh department?")) return;
                    
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
                                    alert(data.message);
                                    location.reload();
                                } else {
                                    alert('Gagal: ' + data.message);
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert('Terjadi kesalahan saat melakukan refresh.');
                            });
                        });
                    </script>
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
