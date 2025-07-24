@extends('layouts.admin')
@section('title', 'Detail Tiket')
@section('content')
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
            <p><strong>Layanan:</strong> {{ $ticket->service_name }}</p>
            <p><strong>Subjek:</strong> {{ $ticket->subject }}</p>
            <p><strong>Deskripsi:</strong> {{ $ticket->description }}</p>
            <p><strong>Customer Email:</strong> {{ $ticket->customer_email }}</p>
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
                        <strong>{{ $conv->user->name }}</strong>
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
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
    
@endsection