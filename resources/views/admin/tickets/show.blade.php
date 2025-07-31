@extends('layouts.admin')
@section('title', 'Detail Tiket')

@push('styles')
<style>
    .hidden { display: none; }

    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
        padding: 10px;
    }

    .chat-item {
        max-width: 100%;
        padding: 12px 16px;
        border-radius: 15px;
        font-size: 14px;
        line-height: 1.5;
        display: inline-block;
        word-wrap: break-word;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .chat-left {
        background-color: #f1f1f1;
        align-self: flex-start;
        border-bottom-left-radius: 0;
    }

    .chat-right {
        background-color: #d4f8cb;
        align-self: flex-end;
        border-bottom-right-radius: 0;
        text-align: right;
    }

    .chat-meta {
        font-size: 0.75rem;
        color: #666;
        margin-top: 5px;
    }

    .chat-bubble-wrap {
        display: flex;
        flex-direction: column;
    }

    .chat-name {
        font-weight: 600;
        margin-bottom: 4px;
        color: #333;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="card-header bg-light text-Black fw-fw-bolder rounded-top">
        DETAIL TIKET
    </div>
    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif

    <!-- Informasi Tiket -->
            @php
            $assignedUser = \App\Models\User::find($ticket->assigned_to);
        @endphp

        <div class="card shadow-sm rounded-3 border-0 mb-4">
            <div class="card-header bg-danger text-white fw-semibold rounded-top">
                Informasi Tiket
            </div>
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Departemen</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->department->name ?? '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Kontak</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->contact_name }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->email }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telepon</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->phone }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Layanan</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->service->name ?? '-' }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Subjek</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->subject }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->description }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Invoice ID</label>
                        <div class="bg-light p-3 rounded border">{{ $ticket->invoice_id }}</div>
                    </div>

                    @if($ticket->attachment)
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lampiran</label>
                        <div class="bg-light p-3 rounded border">
                            <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="text-primary">
                                Download
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <div>
                            <span class="badge px-3 py-2 fs-6 rounded
                                {{ $ticket->status == 'Dalam Antrean' ? 'bg-warning text-dark' : '' }}
                                {{ $ticket->status == 'Dalam Pengerjaan' ? 'bg-info text-dark' : '' }}
                                {{ $ticket->status == 'Solved' ? 'bg-success' : '' }}">
                                {{ $ticket->status ?? 'Dalam Antrean' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Assignment</label>
                        <div class="bg-light p-3 rounded border">
                            {{ $assignedUser ? $assignedUser->name : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!-- Percakapan -->
    <div class="card">
        <div class="card-header bg-danger text-white fw-semibold rounded-top">
            Percakapan
        </div>
        <div class="card-body">
            @if($ticket->conversations && $ticket->conversations->count())
                <div class="chat-container mt-3">
                    @foreach($ticket->conversations as $conv)
                        @php
                            $isAdmin = $conv->user && $conv->user->id === auth()->id();
                            $bubbleClass = $isAdmin ? 'chat-right' : 'chat-left';
                            $senderName = $conv->user->name ?? $ticket->email;
                        @endphp
                        <div class="chat-bubble-wrap {{ $isAdmin ? 'align-self-end text-end' : 'align-self-start text-start' }}">
                            <div class="chat-item {{ $bubbleClass }}">
                                <div class="chat-name">{{ $senderName }}</div>
                                <div>{{ $conv->message }}</div>
                                <div class="chat-meta">{{ $conv->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Belum ada percakapan.</p>
            @endif

            <!-- Form Balasan -->
            <form method="POST" action="{{ route('admin.tickets.reply', $ticket->id) }}" id="replyForm">
                @csrf
                <div class="mb-2">
                    <textarea name="message" rows="3" class="form-control" placeholder="Tulis balasan..." required></textarea>
                </div>
                <input type="hidden" name="status" id="statusInput">

                <div class="d-flex justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Kirim
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); submitWithStatus('Dalam Pengerjaan')">Dalam Pengerjaan</a></li>
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); submitWithStatus('Solved')">Selesai</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-2 d-none" id="submitLoading">
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span> Mengirim...
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function submitWithStatus(status) {
        const form = document.getElementById('replyForm');
        const statusInput = document.getElementById('statusInput');
        const loading = document.getElementById('submitLoading');

        if (form && statusInput) {
            statusInput.value = status;
            if (loading) loading.classList.remove('d-none');
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('replyForm');
        if (form) {
            form.addEventListener('submit', function () {
                const spinner = document.getElementById('submitLoading');
                if (spinner) spinner.classList.remove('d-none');
            });
        }
    });
</script>
@endpush
