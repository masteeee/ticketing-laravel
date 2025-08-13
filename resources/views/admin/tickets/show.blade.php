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
        background-color:rgb(248, 203, 203);
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

    /* Mention styles */
    .mention {
        background-color: #007bff;
        color: white;
        padding: 2px 6px;
        border-radius: 12px;
        font-size: 0.85em;
        font-weight: 500;
    }

    .mention-suggestions {
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .mention-suggestion-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
    }

    .mention-suggestion-item:hover {
        background-color: #f8f9fa;
    }

    .mention-suggestion-item:last-child {
        border-bottom: none;
    }

    .message-input-container {
        position: relative;
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
                        <label class="form-label fw-semibold">Tracking ID</label>
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

                    <div class="col-md-6 mt-2">
                        <label class="form-label fw-semibold">Status</label>
                        <div>
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
                                <div>{!! \App\Http\Controllers\Admin\AdminTicketController::formatMessageWithMentions($conv->message) !!}</div>
                                <div class="chat-meta">{{ $conv->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Belum ada percakapan.</p>
            @endif

            <!-- Form Balasan -->
            <form method="POST" action="{{ route('tickets.reply', $ticket->id) }}" id="replyForm">
                @csrf
                <div class="mb-2 message-input-container">
                    <textarea name="message" rows="3" class="form-control" id="messageInput" placeholder="Tulis balasan... Gunakan @ untuk mention user lain" required></textarea>
                    <div class="mention-suggestions" id="mentionSuggestions"></div>
                </div>
                <input type="hidden" name="status" id="statusInput">

                <div class="d-flex justify-content-end">
                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" {{ $ticket->status === 'Solved' ? 'disabled' : '' }} type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Kirim
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); submitWithStatus('Dalam Antrean')">Dalam Antrean</a></li>
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
    let mentionTimeout;
    let currentMentionQuery = '';

    let isSubmitting = false; // lock global

    function submitWithStatus(status) {
        if (isSubmitting) return; // kalau sudah submit, hentikan

        const form = document.getElementById('replyForm');
        const statusInput = document.getElementById('statusInput');
        const messageTextarea = form.querySelector('textarea[name="message"]');
        const loading = document.getElementById('submitLoading');
        const sendButton = document.querySelector('#dropdownMenuButton');
        const dropdownItems = document.querySelectorAll('.dropdown-menu a');

        // Validasi pesan
        if (!messageTextarea.value.trim()) {
            alert('Pesan tidak boleh kosong!');
            return;
        }

        // Set lock agar tidak bisa submit lagi
        isSubmitting = true;

        // Disable tombol utama
        if (sendButton) {
            sendButton.disabled = true;
            sendButton.innerHTML = 'Mengirim...';
        }

        // Disable semua item dropdown
        dropdownItems.forEach(item => {
            item.classList.add('disabled');
            item.style.pointerEvents = 'none';
            item.style.opacity = '0.5';
        });

        // Set status dan submit
        if (form && statusInput) {
            statusInput.value = status;
            if (loading) loading.classList.remove('d-none');
            form.submit();
        }
    }


    function formatMessageWithMentions(message) {
        return message.replace(/@(\w+)/g, '<span class="mention">@$1</span>');
    }

    function showMentionSuggestions(query) {
        const suggestionsDiv = document.getElementById('mentionSuggestions');
        
        if (!query) {
            suggestionsDiv.style.display = 'none';
            return;
        }

        fetch(`/mention-suggestions?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(users => {
                if (users.length > 0) {
                    suggestionsDiv.innerHTML = users.map(user => 
                        `<div class="mention-suggestion-item" data-username="${user.name}">
                            <strong>${user.name}</strong><br>
                            <small>${user.email}</small>
                        </div>`
                    ).join('');
                    suggestionsDiv.style.display = 'block';
                } else {
                    suggestionsDiv.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching mention suggestions:', error);
                suggestionsDiv.style.display = 'none';
            });
    }

    function insertMention(username) {
        const textarea = document.getElementById('messageInput');
        const cursorPos = textarea.selectionStart;
        const textBefore = textarea.value.substring(0, cursorPos);
        const textAfter = textarea.value.substring(cursorPos);
        
        // Find the last @ symbol before cursor
        const lastAtIndex = textBefore.lastIndexOf('@');
        if (lastAtIndex !== -1) {
            const newText = textBefore.substring(0, lastAtIndex) + '@' + username + ' ' + textAfter;
            textarea.value = newText;
            textarea.selectionStart = textarea.selectionEnd = lastAtIndex + username.length + 2;
        }
        
        document.getElementById('mentionSuggestions').style.display = 'none';
        textarea.focus();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('replyForm');
        const messageInput = document.getElementById('messageInput');
        const suggestionsDiv = document.getElementById('mentionSuggestions');

        if (form) {
            form.addEventListener('submit', function (e) {
                const messageTextarea = form.querySelector('textarea[name="message"]');
                
                // Validate on form submit
                if (!messageTextarea.value.trim()) {
                    e.preventDefault();
                    alert('Pesan tidak boleh kosong!');
                    return;
                }
                
                const spinner = document.getElementById('submitLoading');
                if (spinner) spinner.classList.remove('d-none');
            });
        }

        // Handle mention suggestions
        if (messageInput) {
            messageInput.addEventListener('input', function(e) {
                const cursorPos = e.target.selectionStart;
                const textBefore = e.target.value.substring(0, cursorPos);
                const lastAtIndex = textBefore.lastIndexOf('@');
                
                if (lastAtIndex !== -1) {
                    const query = textBefore.substring(lastAtIndex + 1);
                    if (query.length > 0) {
                        clearTimeout(mentionTimeout);
                        mentionTimeout = setTimeout(() => {
                            showMentionSuggestions(query);
                        }, 300);
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                } else {
                    suggestionsDiv.style.display = 'none';
                }
            });

            // Handle suggestion clicks
            suggestionsDiv.addEventListener('click', function(e) {
                if (e.target.closest('.mention-suggestion-item')) {
                    const username = e.target.closest('.mention-suggestion-item').dataset.username;
                    insertMention(username);
                }
            });

            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.message-input-container')) {
                    suggestionsDiv.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush
