<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketSubmitted;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TicketController extends Controller
{
public function create()
{
    $departments = \App\Models\Department::all(); // Jika form butuh department
    return view('public.ticket.create', compact('departments'));
}
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'contact_name' => 'required|string',
            'subject' => 'required|string',
            'attachment' => 'nullable|file|max:40960' // 40 MB
        ]);

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        $ticket = Ticket::create([
            'department_id' => $request->department_id,
            'contact_name' => $request->contact_name,
            'service_name' => $request->service_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'description' => $request->description,
            'customer_email' => $request->customer_email,
            'invoice_id' => $request->invoice_id,
            'attachment' => $filePath,
        ]);

        // Kirim notifikasi ke admin/staff
        $admins = User::whereIn('role', ['admin', 'staff'])->get();
        Notification::send($admins, new TicketSubmitted($ticket));

        return redirect()->back()->with('success', 'Ticket berhasil dikirim!');
    }
}
