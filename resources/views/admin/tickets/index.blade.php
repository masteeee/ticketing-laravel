@extends('layouts.admin')
@section('title', 'Daftar Tiket')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Tiket</h2>
        <a href="{{ url()->current() }}" class="btn btn-sm btn-primary" title="Refresh">
            <i class="fas fa-sync-alt"></i>
        </a>
    </div>

    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif

    <!-- Filter Section -->
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h5 class="text-danger mb-4">Filter Tiket</h5>
        <form method="GET" action="{{ route('admin.tickets.index') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="department_id" class="form-label">Departemen</label>
                    <select name="department_id" id="department_id" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="service_id" class="form-label">Layanan</label>
                    <select name="service_id" id="service_id" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                        <option value="solved" {{ request('status') == 'solved' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>

                <div class="col-md-3">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-danger me-2">
                        <i class="fas fa-filter me-1"></i> Terapkan
                    </button>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
    
    {{-- Table --}}
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
                    <th>Assignment To</th>
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
                        <span class="badge
                            {{ $ticket->status == 'Dalam Antrean' ? 'bg-warning' : '' }}
                            {{ $ticket->status == 'Dalam Pengerjaan' ? 'bg-info' : '' }}
                            {{ $ticket->status == 'Solved' ? 'bg-success' : '' }}">
                            {{ $ticket->status ?? 'Dalam Antrean' }}
                        </span>
                    </td>
                   
                    <td>
                        <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                               
                                <select name="assigned_to" id="assigned_to" class="form-select" required>
                                    <option value="">-- Pilih Staff --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Assign</button>
                        </form>
                        
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">Tidak ada tiket ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $tickets->links() }}
</div>
@endsection
