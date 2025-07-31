@extends('layouts.admin')
@section('title', 'Detail Tiket')
@section('content')
<style>
    .hidden {
        display: none;
    }
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 16px; /* spasi antar bubble */
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
<div class="container py-4">
    <h2>Detail Tiket</h2>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="card mb-4">
        <div class="card-header">Informasi Tiket</div>
        <div class="card-body">
            <p><strong>Departemen:</strong> {{ $ticket->department->name ?? '-' }}</p>
            <p><strong>Nama Kontak:</strong> {{ $ticket->contact_name }}</p>
            <p><strong>Email:</strong> {{ $ticket->email }}</p>
            <p><strong>Telepon:</strong> {{ $ticket->phone }}</p>
            <p><strong>Layanan:</strong> <td>{{ $ticket->service->name ?? '-' }}</p>
            <p><strong>Subjek:</strong> {{ $ticket->subject }}</p>
            <p><strong>Deskripsi:</strong> {{ $ticket->description }}</p>
            <p><strong>Inv ID:</strong> {{ $ticket->invoice_id }}</p>
            @if($ticket->attachment)
                <p><strong>Lampiran:</strong> <a href="{{ Storage::url($ticket->attachment) }}" target="_blank">Download</a></p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">Percakapan</div>
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
    
            <form method="POST" action="{{ route('admin.tickets.reply', $ticket->id) }}" id="replyForm">
                @csrf
                <div class="mb-2">
                    <textarea name="message" rows="3" class="form-control" placeholder="Tulis balasan..." required></textarea>
                </div>
            
                <input type="hidden" name="status" id="statusInput">
            
                <!-- Tombol dropdown status -->
                <div class="d-flex justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Kirim
                        </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); submitWithStatus('Dalam pengerjaan')">Dalam Pengerjaan</a></li>
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); submitWithStatus('Solved')">Selesai</a></li>
                    </ul>
                </div>
                
                
            
                <div class="mt-2 d-none" id="submitLoading">
                    <span class="spinner-border spinner-border-sm text-primary" role="status"></span> Mengirim...
                </div>
            </form>
            
        </div>
    </div>
    
@endsection

@section('scripts')
<script>
    // ✅ Fungsi ini harus DI LUAR DOMContentLoaded supaya bisa diakses global
    function submitWithStatus(status) {
        const form = document.getElementById('replyForm');
        const statusInput = document.getElementById('statusInput');

        if (form && statusInput) {
            statusInput.value = status;

            // Tampilkan animasi loading kalau ada
            const loading = document.getElementById('submitLoading');
            if (loading) loading.classList.remove('d-none');

            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('replyForm');
        if (form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('admin-reply-btn');
                const text = document.getElementById('admin-reply-text');
                const spinner = document.getElementById('admin-reply-spinner');
                if (btn) btn.disabled = true;
                if (text) text.classList.add('d-none');
                if (spinner) spinner.classList.remove('hidden');
            });
        }
    });
</script>
@endsection
