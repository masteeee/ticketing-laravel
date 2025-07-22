@extends('layouts.admin') {{-- Gunakan layout admin milikmu --}}

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Ticket</h1>

    <div class="overflow-auto rounded shadow">
        <table class="min-w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Subjek</th>
                    <th class="px-4 py-2 border">Layanan</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $ticket->contact_name }}</td>
                        <td class="px-4 py-2 border">{{ $ticket->email }}</td>
                        <td class="px-4 py-2 border">{{ $ticket->subject }}</td>
                        <td class="px-4 py-2 border">{{ $ticket->service_name }}</td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 text-sm rounded 
                                @if($ticket->status == 'Dalam Antrean') bg-yellow-100 text-yellow-800
                                @elseif($ticket->status == 'Sedang Dikerjakan') bg-blue-100 text-blue-800
                                @elseif($ticket->status == 'Selesai') bg-green-100 text-green-800
                                @endif
                            ">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <form action="{{ route('admin.tickets.update-status', $ticket->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-sm rounded border-gray-300" onchange="this.form.submit()">
                                    <option disabled selected>Ubah Status</option>
                                    <option value="Dalam Antrean">Dalam Antrean</option>
                                    <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->links() }} {{-- Pagination --}}
    </div>
</div>
@endsection
