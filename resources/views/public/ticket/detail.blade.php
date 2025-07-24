@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-red-600 mb-4">Detail Ticket</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mb-4">
                <div><b>Invoice:</b> {{ $ticket->invoice_id }}</div>
                <div><b>Email:</b> {{ $ticket->email }}</div>
                <div><b>Nama Kontak:</b> {{ $ticket->contact_name }}</div>
                <div><b>Departemen:</b> {{ $ticket->department->name ?? '-' }}</div>
                <div><b>Subjek:</b> {{ $ticket->subject }}</div>
                <div><b>Status:</b> {{ $ticket->status }}</div>
            </div>
            <div class="mb-2"><b>Deskripsi:</b><br> <span class="text-gray-700">{{ $ticket->description }}</span></div>
        </div>
        <div class="mb-6">
            <h3 class="font-semibold mb-3">Percakapan</h3>
            <div class="space-y-4 max-h-64 overflow-y-auto">
                @forelse($conversations as $conv)
                    <div class="bg-white rounded shadow p-4 border-l-4 {{ $conv->user ? 'border-blue-500' : 'border-gray-400' }}">
                        <div class="font-bold text-sm mb-1">{{ $conv->user->name ?? 'Anda' }}</div>
                        <div class="text-gray-800">{{ $conv->message }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ $conv->created_at->format('d M Y H:i') }}</div>
                    </div>
                @empty
                    <div class="text-gray-400">Belum ada balasan.</div>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Kirim Balasan</h3>
            <form method="POST" action="{{ route('ticket.public.reply', ['inv' => $ticket->invoice_id, 'email' => $ticket->email]) }}">
                @csrf
                <textarea name="message" class="form-control w-full border border-gray-300 rounded mb-3" rows="3" required placeholder="Tulis balasan..."></textarea>
                <button class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition">Kirim</button>
            </form>
        </div>
    </div>
</div>
@endsection 