@extends('layouts.admin')
@section('title', 'Daftar Tiket')
@section('content')
<div class="container py-4" style="font-family: 'Segoe UI', sans-serif;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="card-header bg-light text-Black fw-semibold rounded-top">
            DAFTAR TIKET
        </div>
        <a href="{{ url()->current() }}" class="btn btn-sm btn-primary" title="Refresh">
            <i class="fas fa-sync-alt"></i>
        </a>
    </div>

    @if(session('success')) 
        <div class="alert alert-success fs-6">{{ session('success') }}</div> 
    @endif

    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h4 class="text-danger fw-bold mb-4 fs-5">Filter Tiket</h4>
            <form method="GET" action="{{ route('admin.tickets.index') }}">
                <div class="row gy-3 gx-2 mb-3">
                    <div class="col-md-3">
                        <label for="department_id" class="form-label fs-6">Departemen</label>
                        <select name="department_id" id="department_id" class="form-select border">
                            <option value="">-- Semua --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="service_id" class="form-label fs-6">Layanan</label>
                        <select name="service_id" id="service_id" class="form-select border">
                            <option value="">-- Semua --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label fs-6">Status</label>
                        <select name="status" id="status" class="form-select border">
                            <option value="">-- Semua --</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                            <option value="solved" {{ request('status') == 'solved' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="row gy-3 gx-2 align-items-end">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label fs-6">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label fs-6">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-danger flex-fill">
                            <i class="fas fa-filter me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary flex-fill">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center shadow-sm fs-6">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Departemen</th>
                    <th>Nama Kontak</th>
                    <th>Layanan</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Assign To</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->department->name ?? '-' }}</td>
                    <td>{{ $ticket->contact_name }}</td>
                    <td>{{ $ticket->service->name ?? '-' }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->phone }}</td>
                    <td>
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                    </td>
                    <td>
                        <span class="badge px-3 py-2 
                            {{ $ticket->status == 'Dalam Antrean' ? 'bg-warning text-dark' : '' }}
                            {{ $ticket->status == 'Dalam Pengerjaan' ? 'bg-info text-dark' : '' }}
                            {{ $ticket->status == 'Solved' ? 'bg-success' : '' }}">
                            {{ $ticket->status ?? 'Dalam Antrean' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="input-group mb-2">
                                <select name="assigned_to" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih Staff --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-danger">Assign</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-3">Tidak ada tiket ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
</div>
@endsection
