@extends('layouts.guest')

@push('styles')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 20px;
        max-height: 400px;
        overflow-y: auto;
        border-radius: 8px;
    }

    .hidden { display: none; }

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
        background-color: #ff6b6b;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 0;
        text-align: right;
    }

    .chat-meta {
        font-size: 0.75rem;
        margin-top: 5px;
    }

    .chat-left .chat-meta {
        color: #666;
    }

    .chat-right .chat-meta {
        color: rgba(255, 255, 255, 0.8);
    }

.chat-bubble-wrap {
    display: flex;
    flex-direction: column;
}

    .chat-name {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .chat-left .chat-name {
        color: #333;
    }

    .chat-right .chat-name {
        color: rgba(255, 255, 255, 0.9);
    }

 

    .chat-left .chat-name {
        color: #495057;
    }

    .chat-right .chat-name {
        color: rgba(255, 255, 255, 0.95);
    }

    /* Custom scrollbar */
    .chat-container::-webkit-scrollbar {
        width: 6px;
    }

    .chat-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .chat-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .chat-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold text-red-600 mb-4">Detail Ticket</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 mb-4">
                <div><b>Invoice:</b> {{ $ticket->invoice_id }}</div>
                <div><b>Email:</b> {{ $ticket->email }}</div>
                <div><b>Nama Kontak:</b> {{ $ticket->contact_name }}</div>
                <div><b>Departemen:</b> {{ $ticket->department->name ?? '-' }}</div>
                <div><b>Subjek:</b> {{ $ticket->subject }}</div>
                <div><b>Layanan:</b> {{ $ticket->service->name ?? '-' }}</div>
                <div><b>Status:</b> 
                    @php
                        $statusStyle = '';
                        switch($ticket->status) {
                            case 'Dalam Antrean':
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 14px; font-weight: 500; border-radius: 20px; background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b;';
                                break;
                            case 'Dalam Pengerjaan':
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 14px; font-weight: 500; border-radius: 20px; background-color: #dbeafe; color: #1e40af; border: 1px solid #3b82f6;';
                                break;
                            case 'Solved':
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 14px; font-weight: 500; border-radius: 20px; background-color: #dcfce7; color: #166534; border: 1px solid #22c55e;';
                                break;
                            default:
                                $statusStyle = 'display: inline-block; padding: 4px 12px; font-size: 14px; font-weight: 500; border-radius: 20px; background-color: #fef3c7; color: #92400e; border: 1px solid #f59e0b;';
                        }
                    @endphp
                    <span style="{{ $statusStyle }}">{{ $ticket->status ?? 'Dalam Antrean' }}</span>
                </div>
            </div>
            <div class="mb-2"><b>Deskripsi:</b><br> <span class="text-gray-700">{{ $ticket->description }}</span></div>
            <div>
                @if($ticket->attachment)
                    <b>Attachment : </b>
                    <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="text-primary">
                    Download
                @endif
            </a>
            </div>
            
        </div>
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Percakapan</h3>
            @if($conversations && $conversations->count())
                <div class="chat-container">
                    @foreach($conversations as $conv)
                        @php
                            $isCustomer = !$conv->user || $conv->user->email === $ticket->email;
                            $bubbleClass = $isCustomer ? 'chat-right' : 'chat-left';
                            $senderName = $conv->user ? $conv->user->name : 'Anda';
                        @endphp
                        <div class="chat-bubble-wrap {{ $isCustomer ? 'align-self-end text-end' : 'align-self-start text-start' }}">
                            <div class="chat-item {{ $bubbleClass }}">
                                <div class="chat-name">{{ $senderName }}</div>
                                <div>{{ $conv->message }}</div>
                                <div class="chat-meta">{{ $conv->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-sm">Belum ada percakapan.</div>
                </div>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Kirim Balasan</h3>
            <form method="POST" action="{{ route('ticket.public.reply', ['inv' => $ticket->invoice_id, 'email' => $ticket->email]) }}">
                @csrf
                <textarea name="message" class="form-control w-full border border-gray-300 rounded mb-3 p-4" rows="3" required placeholder="Tulis balasan..."></textarea>
                <button type="submit" id="reply-ticket-btn" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition flex items-center gap-2" style="background-color: #FF0000; color: white; border: none; ">
                    <span id="reply-ticket-text">Kirim</span>
                    <span id="reply-ticket-spinner" class="hidden animate-spin"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg></span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.tailwindcss.com"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="ticket.public.reply"]');
    if(form) {
        form.addEventListener('submit', function() {
            const btn = document.getElementById('reply-ticket-btn');
            btn.disabled = true;
            document.getElementById('reply-ticket-text').classList.add('hidden');
            document.getElementById('reply-ticket-spinner').classList.remove('hidden');
        });
    }
});
</script>
@endsection 