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

    @if(session('error'))
        <div class="alert alert-danger fs-6">{{ session('error') }}</div>
    @endif

    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-body">
            <h4 class="text-danger fw-bold mb-4 fs-5">Filter Tiket</h4>
            <form method="GET" action="{{ route('tickets.index') }}">
                {{-- Baris 1 --}}
                <div class="row gy-2 gx-3 mb-3">
                    <div class="col-md-3">
                        <label for="department_id" class="form-label fs-6">Departemen</label>
                        <select name="department_id" id="department_id" class="form-control">
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
                        <select name="service_id" id="service_id" class="form-control">
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
                        <select name="status" id="status" class="form-control">
                            <option value="">-- Semua --</option>
                            <option value="Dalam Antrean" {{ request('status') == 'Dalam Antrean' ? 'selected' : '' }}>Open</option>
                            <option value="Dalam Pengerjaan" {{ request('status') == 'Dalam Pengerjaan' ? 'selected' : '' }}>Dalam Pengerjaan</option>
                            <option value="Solved" {{ request('status') == 'Solved' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="assigned_to" class="form-label fs-6">Assigned To</label>
                        <select name="assigned_to" id="assigned_to" class="form-control">
                            <option value="">-- Semua --</option>
                            <option value="unassigned" {{ request('assigned_to') == 'unassigned' ? 'selected' : '' }}>Belum Di-assign</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                {{-- Baris 2 --}}
                <div class="row gy-2 gx-3 mb-3">
                    <div class="col-md-3">
                        <label for="email" class="form-label fs-6">Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Cari email..." value="{{ request('email') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="invoice_id" class="form-label fs-6">ID Tiket</label>
                        <input type="text" name="invoice_id" id="invoice_id" class="form-control" 
                               placeholder="Cari ID Tiket..." value="{{ request('invoice_id') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label fs-6">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label fs-6">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                </div>
    
                {{-- Tombol --}}
                <div class="row mt-3">
                    <div class="col d-flex gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-filter me-1"></i> Terapkan
                        </button>
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    

    <div class="table-responsive table-bordered">
        <table class="table table-bordered align-middle text-center shadow-sm fs-6">
            <thead class="table-light">
                <tr class="text-black">
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
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                    </td>
                    <td>
                    @php
                        $statusStyle = '';
                        switch($ticket->status) {
                            case 'Dalam Antrean':
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 12px; font-weight: 500; border-radius: 20px; background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b;';
                                break;
                            case 'Dalam Pengerjaan':
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 12px; font-weight: 500; border-radius: 20px; background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6;';
                                break;
                            case 'Solved':
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 12px; font-weight: 500; border-radius: 20px; background-color: #dcfce7; color: #166534; border: 1px solid #22c55e;';
                                break;
                            default:
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 12px; font-weight: 500; border-radius: 20px; background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b;';
                        }
                    @endphp
                    <span style="{{ $statusStyle }}">{{ $ticket->status ?? 'Dalam Antrean' }}</span>
                    </td>
                    <td>
                        @php
                            $user = Auth::user();
                            $userPermissions = $user && $user->role ? $user->role->permissions->pluck('name')->toArray() : [];

                            $canAssign = function($perm) use ($userPermissions) {
                                return in_array($perm, $userPermissions);
                            };
                        @endphp

                        
                        @if($canAssign('assign tickets'))
                            <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST" class="auto-assign-form">
                                @csrf
                                <div class="input-group mb-2">
                                    <select name="assigned_to" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm auto-assign-select" data-ticket-id="{{ $ticket->id }}" required>
                                        <option value="">-- Pilih Staff --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        @else
                            <div class="p-2">
                                @if($ticket->assigned_to)
                                    @php
                                        $assignedUser = \App\Models\User::find($ticket->assigned_to);
                                    @endphp
                                    <span class="text-sm">{{ $assignedUser ? $assignedUser->name : 'Tidak ada' }}</span>
                                @else
                                    <span class="text-sm text-muted">Belum di-assign</span>
                                @endif
                            </div>
                        @endif
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-assign functionality - only for admin users
    const assignSelects = document.querySelectorAll('.auto-assign-select');
    
    assignSelects.forEach(select => {
        select.addEventListener('change', function() {
            const selectedValue = this.value;
            const selectedText = this.options[this.selectedIndex].text;
            const form = this.closest('.auto-assign-form');
            
            if (selectedValue) {
                // Show confirmation dialog
                if (confirm(`Apakah Anda yakin ingin mengassign tiket ini kepada ${selectedText}?`)) {
                    // Store current value for potential reset
                    this.setAttribute('data-previous-value', selectedValue);
                    
                    // Auto-submit the form
                    form.submit();
                } else {
                    // Reset to previous value if user cancels
                    this.value = this.getAttribute('data-previous-value') || '';
                }
            }
        });
    });

    // Date range validation
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const filterForm = document.querySelector('form[method="GET"]');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && this.value > endDateInput.value) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
                this.value = '';
            }
        });

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && this.value < startDateInput.value) {
                alert('Tanggal akhir tidak boleh lebih kecil dari tanggal mulai!');
                this.value = '';
            }
        });
    }

    // Form validation before submit
    if (filterForm) {
        filterForm.addEventListener('submit', function(e) {
            if (startDateInput && endDateInput && startDateInput.value && endDateInput.value) {
                if (startDateInput.value > endDateInput.value) {
                    e.preventDefault();
                    alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
                    return false;
                }
            }
        });
    }
});
</script>

@endsection
