@extends('layouts.admin')
@section('title', 'Daftar Tiket')
@section('content')
<div class="container py-4">
    <h2>Daftar Tiket</h2>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Departemen</th>
                    <th>Nama Kontak</th>
                    <th>Layanan</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->department->name ?? '-' }}</td>
                    <td>{{ $ticket->contact_name }}</td>
                    <td>{{ $ticket->service_name }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->phone }}</td>
                    <td><a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">Lihat</a></td>
                    <td>
                        <span class="badge
                            {{ $ticket->status == 'Dalam Antrean' ? 'bg-warning' : '' }}
                            {{ $ticket->status == 'Dalam Pengerjaan' ? 'bg-info' : '' }}
                            {{ $ticket->status == 'Solved' ? 'bg-success' : '' }}">
                            {{ $ticket->status ?? 'Dalam Antrean' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="Dalam Antrean" {{ $ticket->status == 'Dalam Antrean' ? 'selected' : '' }}>Dalam Antrean</option>
                                <option value="Dalam Pengerjaan" {{ $ticket->status == 'Dalam Pengerjaan' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                                <option value="Solved" {{ $ticket->status == 'Solved' ? 'selected' : '' }}>Solved/Done</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $tickets->links() }}
</div>
@endsection