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
use App\Models\Service;



class TicketController extends Controller
{public function index(Request $request)
    {
        $query = Ticket::query();
    
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
    
        if ($request->filled('service_id')) {
            $query->where('service_name', $request->service_id);
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
    
        $tickets = $query->latest()->paginate(10);
        $departments = Department::all();
        $services = Service::all();
        $users = User::all();
    
        return view('admin.tickets.index', compact('tickets', 'departments', 'services','users'));
    }
    

    // Halaman form publik untuk submit tiket
    public function create()
    {
        $departments = Department::all();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();
        $selectedDepartment = request('department');
        $services = Service::all();

        return view('public.ticket.create', compact('departments', 'popularArticles', 'selectedDepartment','services'));
    }

    // Proses simpan tiket baru
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'contact_name' => 'required|string',
            'service_id' => 'required|exists:services,id',
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
            $invoiceId = 'TR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        }

        $ticket = Ticket::create([
            'department_id'   => $request->department_id,
            'contact_name'    => $request->contact_name,
            'service_id'      => $request->service_id,
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
        public function getServices($department_id)
        {
            $services = \App\Models\Service::where('department_id', $department_id)->get();
            return response()->json($services);
        }
        public function assignHandler(Request $request, Ticket $ticket)
{
    $request->validate([
        'handler_id' => 'nullable|exists:users,id',
    ]);

    $ticket->handler_id = $request->handler_id;
    $ticket->save();

    return redirect()->back()->with('success', 'Tiket berhasil di-assign.');
}

}