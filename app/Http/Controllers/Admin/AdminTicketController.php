<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TicketUserReplied;
use App\Models\User;

class AdminTicketController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();
        $services = Service::all();

        $query = Ticket::with(['department', 'service', 'handler',]);
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'staff');
        })->get();
        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $tickets = $query->latest()->paginate(10);

        return view('admin.tickets.index', compact('tickets', 'departments', 'services','users'));
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
        $conversations = []; // Placeholder

        return view('admin.tickets.show', compact('ticket', 'conversations',));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
            'status' => 'nullable|in:Dalam Antrean,Dalam Pengerjaan,Solved', 
            'assigned_to' => 'nullable|exists:users,id',
        ]);
    
        // Tambah percakapan
        $ticket->conversations()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
    
        // Update status jika ada
        if ($request->filled('status')) {
            $ticket->status = $request->status;

            // Assign handler jika belum ditangani
            if ($ticket->handled_by === null && auth()->check()) {
                $ticket->handled_by = auth()->id();
            }

            $ticket->save();
        }
    
        // Kirim notifikasi ke user (jika ada email)
        if ($ticket->email) {
            \Notification::route('mail', $ticket->email)->notify(new TicketUserReplied($ticket, $request->message));
        }
    
        return back()->with('success', 'Balasan berhasil dikirim dan status diperbarui.');
    }
    
    public function assign(Request $request, Ticket $ticket)
    {
        $ticket->assigned_to = $request->assigned_to;
        $ticket->save();

        return back()->with('success', 'Ticket assigned successfully.');
    }

    
}
