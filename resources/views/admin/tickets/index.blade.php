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
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="text-danger mb-0">Filter Tiket</h5>
    </div>
    <div class="card-body">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="department" class="form-label">Departemen</label>
                    <select name="department_id" id="department" class="form-select">
                        <option value="">-- Semua Departemen --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="service" class="form-label">Layanan</label>
                    <select name="service_id" id="service" class="form-select">
                        <option value="">-- Semua Layanan --</option>
                        @foreach($services as $srv)
                            <option value="{{ $srv->id }}" {{ request('service_id') == $srv->id ? 'selected' : '' }}>
                                {{ $srv->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="Dalam Antrean" {{ request('status') == 'Dalam Antrean' ? 'selected' : '' }}>Dalam Antrean</option>
                        <option value="Dalam Pengerjaan" {{ request('status') == 'Dalam Pengerjaan' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                        <option value="Solved" {{ request('status') == 'Solved' ? 'selected' : '' }}>Solved</option>
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

                <div class="col-md-3 align-self-end d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Terapkan Filter</button>
                </div>

                <div class="col-md-3 align-self-end d-grid gap-2">
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Reset</a>
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
                    <th>Ubah Status</th>
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
                        <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="Dalam Antrean" {{ $ticket->status == 'Dalam Antrean' ? 'selected' : '' }}>Dalam Antrean</option>
                                <option value="Dalam Pengerjaan" {{ $ticket->status == 'Dalam Pengerjaan' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                                <option value="Solved" {{ $ticket->status == 'Solved' ? 'selected' : '' }}>Solved/Done</option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $ticket->handler->name ?? '-' }}</td>
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
