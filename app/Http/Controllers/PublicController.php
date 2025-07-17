<?php

namespace App\Http\Controllers;

use App\Models\Department; 

class PublicController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('public.home', compact('departments'));
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
