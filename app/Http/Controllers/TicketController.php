<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Notifications\TicketSubmitted;
use App\Models\Article;
use App\Notifications\TicketUserSubmitted;


class TicketController extends Controller
{
    // Halaman form publik untuk submit tiket
    public function create()
    {
        $departments = Department::all();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $selectedDepartment = request('department');
        $services = [];

        return view('public.ticket.create', compact('departments', 'popularArticles', 'selectedDepartment','services'));
    }

    // Proses simpan tiket baru
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'contact_name' => 'required|string',
            'service_name' => 'nullable|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'required|string',
            'description' => 'nullable|string',
            'customer_email' => 'nullable|email',
            'invoice_id' => 'nullable|string',
            'attachment' => 'nullable|file|max:40960', // maks 40 MB
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        // Generate invoice_id jika belum ada
        $invoiceId = $request->invoice_id;
        if (!$invoiceId) {
            $invoiceId = 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        }

        $ticket = Ticket::create([
            'department_id'   => $request->department_id,
            'contact_name'    => $request->contact_name,
            'service_name'    => $request->service_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'subject'         => $request->subject,
            'description'     => $request->description,
            'customer_email'  => $request->customer_email,
            'invoice_id'      => $invoiceId,
            'attachment'      => $filePath,
            'status'          => 'Dalam Antrean',
        ]);

        // Kirim notifikasi ke admin dan staff
        $admins = User::whereHas('role', function($q) {
            $q->whereIn('name', ['admin', 'staff']);
        })->get();
        Notification::send($admins, new TicketSubmitted($ticket));

        // Kirim notifikasi ke user
        if ($ticket->email) {
            \Notification::route('mail', $ticket->email)->notify(new TicketUserSubmitted($ticket));
        }

        return redirect()->route('ticket.success', [
            'inv' => $invoiceId,
            'email' => $request->email,
        ]);
    }

    // Form input INV & email
    public function viewForm()
    {
        return view('public.ticket.view');
    }

    // Detail ticket publik berdasarkan INV & email
    public function publicDetail(Request $request)
    {
        $request->validate([
            'inv' => 'required|string',
            'email' => 'required|email',
        ]);
        $ticket = Ticket::where('invoice_id', $request->inv)
            ->where('email', $request->email)
            ->first();
        if (!$ticket) {
            return redirect()->route('ticket.view.form')->with('error', 'Ticket tidak ditemukan atau email salah.');
        }
        $conversations = $ticket->conversations()->with('user')->get();
        return view('public.ticket.detail', compact('ticket', 'conversations'));
    }

    public function publicReply(Request $request)
    {
        $request->validate([
            'inv' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        $ticket = Ticket::where('invoice_id', $request->inv)
            ->where('email', $request->email)
            ->first();
        if (!$ticket) {
            return redirect()->route('ticket.view.form')->with('error', 'Ticket tidak ditemukan atau email salah.');
        }
        $ticket->conversations()->create([
            'user_id' => null, // public user
            'message' => $request->message,
        ]);
        // Kirim notifikasi ke admin/staff
        $admins = User::whereHas('role', function($q) {
            $q->whereIn('name', ['admin', 'staff']);
        })->get();
        \Notification::send($admins, new TicketSubmitted($ticket));
        return redirect()->route('ticket.public.detail', ['inv' => $ticket->invoice_id, 'email' => $ticket->email]);
    }
}
    