@extends('layouts.admin')
@section('title', 'Detail Tiket')
@section('content')
<style>
    .hidden {
        display: none;
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
            <p><strong>Layanan:</strong> {{ $ticket->service->name ?? '-' }}</p>
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
                @foreach($ticket->conversations as $conv)
                    <div class="mb-2">
                        <strong>
                            @if($conv->user)
                                {{ $conv->user->name }}
                            @else
                                {{ $ticket->email }}
                            @endif
                        </strong>
                        <small class="text-muted">({{ $conv->created_at->diffForHumans() }})</small>
                        <p>{{ $conv->message }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Belum ada percakapan.</p>
            @endif
    
            <form method="POST" action="{{ route('admin.tickets.reply', $ticket->id) }}">
                @csrf
                <div class="mb-2">
                    <textarea name="message" rows="3" class="form-control" placeholder="Tulis balasan..."></textarea>
                </div>
                <div class="mb-2">
                    <label for="status"><strong>Status Tiket</strong></label>
                    <select name="status" id="status" class="form-control">
                        <option value="dalam_pengerjaan">Dalam Pengerjaan</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <button type="submit" id="admin-reply-btn" class="btn btn-primary flex items-center gap-2">
                    <span id="admin-reply-text">Kirim</span>
                    <span id="admin-reply-spinner" class="hidden">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </span>
                </button>
            </form>
            
        </div>
    </div>
    
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="tickets.reply"]');
    if(form) {
        form.addEventListener('submit', function() {
            const btn = document.getElementById('admin-reply-btn');
            btn.disabled = true;
            document.getElementById('admin-reply-text').classList.add('d-none');
            document.getElementById('admin-reply-spinner').classList.remove('hidden');
        });
    }
});
</script>
@endsection