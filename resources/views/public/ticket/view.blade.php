@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="p-4" style="max-width: 500px; margin: 0 auto; padding: 20px;">
        <div class="bg-white rounded-lg p-8 shadow">
            <h2 class="text-2xl font-bold text-center text-red-keloola mb-6">View Ticket</h2>

            {{-- Form View Ticket --}}
            <form method="GET" action="{{ route('ticket.public.detail') }}" class="p-4">
                <div class="mb-4">
                    <label for="inv" class="block text-sm font-medium mb-2">Tracking ID</label>
                    <input type="text" name="inv" id="inv" value="{{ old('inv') }}"
                           class="form-control w-full p-3 border border-gray-300 rounded"
                           required placeholder="Masukkan kode Tracking ID Anda">
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="form-control w-full p-3 border border-gray-300 rounded"
                           required placeholder="Masukkan email Anda">
                </div>
                <button class="w-full bg-red-keloola text-white-primary py-3 rounded font-semibold text-lg hover:bg-red-700 transition">
                    View Ticket
                </button>
            </form>

            {{-- Info --}}
            <div class="mt-6 text-center text-gray-500 text-sm">
                Masukkan kode Tracking ID (INV) dan email Anda untuk melihat status dan balasan tiket.
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: @json(session('error')),
        confirmButtonText: 'Coba Lagi',
    });
</script>
@endif
@endsection
