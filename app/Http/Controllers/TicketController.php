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


class TicketController extends Controller
{
    // Halaman form publik untuk submit tiket
    public function create()
    {
        $departments = Department::all();
        $popularArticles = Article::orderBy('views', 'desc')->take(5)->get();

        return view('public.ticket.create', compact('departments', 'popularArticles'));
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

        $ticket = Ticket::create([
            'department_id'   => $request->department_id,
            'contact_name'    => $request->contact_name,
            'service_name'    => $request->service_name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'subject'         => $request->subject,
            'description'     => $request->description,
            'customer_email'  => $request->customer_email,
            'invoice_id'      => $request->invoice_id,
            'attachment'      => $filePath,
            'status'          => 'Dalam Antrean',
        ]);

        // Kirim notifikasi ke admin dan staff
        $admins = User::whereIn('role', ['admin', 'staff'])->get();
        Notification::send($admins, new TicketSubmitted($ticket));

        return redirect()->back()->with('success', 'Ticket berhasil dikirim!');
    }
}
    