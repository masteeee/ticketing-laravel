@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="p-4" style="max-width: 500px; margin: 0 auto; padding: 20px;">
        <div class="bg-white rounded-lg p-8">
            <h2 class="text-2xl font-bold text-center text-red-keloola mb-6">View Ticket</h2>
            @if(session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif
            <form method="GET" action="{{ route('ticket.public.detail') }}" class="p-4">
                <div class="mb-4">
                    <label for="inv" class="block text-sm font-medium mb-2">Invoice Number (INV)</label>
                    <input type="text" name="inv" id="inv" class="form-control w-full p-3 border border-gray-300 rounded" required placeholder="Masukkan kode INV Anda">
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" class="form-control w-full p-3 border border-gray-300 rounded" required placeholder="Masukkan email Anda">
                </div>
                <button class="w-full bg-red-keloola text-white-primary py-3 rounded font-semibold text-lg hover:bg-red-700 transition">View Ticket</button>
            </form>
            <div class="mt-6 text-center text-gray-500 text-sm" style="margin: 20px;">
                Masukkan kode INV dan email Anda untuk melihat status dan balasan tiket.
            </div>
        </div>
    </div>
</div>
@endsection 