<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketConversation;
use App\Notifications\TicketUserReplied;
use Illuminate\Support\Facades\Auth;

class AdminTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    public function updateStatus(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $ticket->status = $request->status;

    if ($ticket->handled_by === null && Auth::check()) {
        $ticket->handled_by = Auth::id(); // Assign staff yang login
    }

    $ticket->save();

    return back()->with('success', 'Status tiket berhasil diperbarui.');
}
    public function show($id)
    {
        $ticket = Ticket::with('department')->findOrFail($id);
        $conversations = []; // nanti bisa isi dengan model percakapan kalau sudah dibuat

        return view('admin.tickets.show', compact('ticket', 'conversations'));
    }
    
    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate(['message' => 'required|string']);

        $ticket->conversations()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        // Kirim notifikasi ke user
        if ($ticket->email) {
            \Notification::route('mail', $ticket->email)->notify(new TicketUserReplied($ticket, $request->message));
        }

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}
