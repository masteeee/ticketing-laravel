@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-16 px-4">
    <div class="max-w-lg w-full text-center animate__animated animate__fadeInDown">
        
        {{-- ICON SUKSES --}}
        <div class="flex justify-center mb-4">
            <div class="bg-green-100 text-green-600 rounded-full p-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        {{-- PESAN --}}
        <h2 class="text-2xl font-bold text-green-600 mb-2">Tiket Berhasil Dikirim!</h2>
        <p class="text-gray-700 mb-4 text-sm md:text-base">
            Terima kasih telah menghubungi kami. Silakan cek email Anda untuk melihat detail tiket.
        </p>

        {{-- KODE INV --}}
        <div class="mb-4">
            <p class="text-sm text-gray-800">Kode INV Anda:</p>
            <div class="flex items-center justify-center gap-2 mt-1">
                <p id="invCode" class="text-xl font-mono font-bold text-blue-600 tracking-wide">{{ $invoice }}</p>
                <button onclick="copyInvoice()" class="text-xs bg-blue-100 border border-blue-500 p-2 rounded-full text-blue-500">Copy</button>
            </div>
        </div>

        {{-- QR CODE --}}
        <div class="flex justify-center my-4">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode(url('/ticket/detail?inv=' . $invoice . '&email=' . $email)) }}&size=100x100" alt="QR Code">
        </div>

        {{-- TOMBOL --}}
        <div class="flex sm:flex-row justify-center gap-3 mt-6">
            <a href="{{ url('/') }}" class="bg-orange-400 w-87 mb-4 text-black border border-orange-400 hover:bg-orange-500 text-sm px-5 py-2 rounded-full shadow-md hover:bg-blue-200 transition font-semibold">
                Kembali ke Beranda
            </a>
            <br>
        </div>
    </div>
</div>

{{-- SCRIPT COPY --}}
<script>
    function copyInvoice() {
        const inv = document.getElementById('invCode').textContent;
        navigator.clipboard.writeText(inv).then(() => {
            alert('Kode INV berhasil disalin!');
        });
    }

    // OPTIONAL: Auto redirect (misalnya setelah 10 detik)
    // setTimeout(() => {
    //     window.location.href = "{{ route('ticket.public.detail', ['inv' => $invoice, 'email' => session('email')]) }}";
    // }, 10000);
</script>
@endsection
