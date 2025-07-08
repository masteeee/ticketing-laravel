<?php

namespace App\Http\Controllers;

class PublicController extends Controller
{
    public function index()
    {
        return view('public.home');
    }

    public function knowledgeBase()
    {
        return view('public.knowledge-base');
    }

    public function submitTicket()
    {
        return view('public.submit-ticket');
    }
}
