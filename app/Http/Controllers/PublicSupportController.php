<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSupportMail;

class PublicSupportController extends Controller
{
    public function showForm()
    {
        return view('public.support-form'); // Buat view ini nanti
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        $data = $request->only('name', 'email', 'message');

        Mail::to('support@keloola.com')->send(new ContactSupportMail($data));

        return back()->with('success', 'Pesan berhasil dikirim ke tim support!');
    }
}
