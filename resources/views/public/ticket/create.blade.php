@extends('layouts.guest')

@section('title', 'Submit a Request')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="{{ asset('dist/css/output.css') }}">
</head>
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 md:px-10 py-10">
    <!-- Form Submit a Request -->
    <div class="md:col-span-2 bg-white rounded shadow p-6">
        <h2 class="text-xl font-bold mb-4">Submit a Request</h2>

        <form enctype="multipart/form-data">
            <!-- Department -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Department</label>
                <select class="w-full border rounded p-2">
                    <option>Keloola Accounting</option>
                    <!-- Tambahkan opsi lainnya -->
                </select>
            </div>

            <!-- Contact Name -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Contact Name *</label>
                <input type="text" class="w-full border rounded p-2" required>
            </div>

            <!-- Service Name -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Keloola Service Name</label>
                <select class="w-full border rounded p-2">
                    <option>-None-</option>
                    <!-- Tambahkan opsi -->
                </select>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Email</label>
                <input type="email" class="w-full border rounded p-2">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Phone</label>
                <input type="text" class="w-full border rounded p-2">
            </div>

            <!-- Subject -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Subject *</label>
                <input type="text" class="w-full border rounded p-2" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Description</label>
                <textarea class="w-full border rounded p-2" rows="4"></textarea>
            </div>

            <!-- Email Primary -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Customer Primary Email Address</label>
                <input type="email" class="w-full border rounded p-2">
            </div>

            <!-- Inv ID -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Inv ID</label>
                <input type="text" class="w-full border rounded p-2">
            </div>

            <!-- File Upload -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Attach a file (up to 40 MB)</label>
                <input type="file" class="w-full">
            </div>

            <!-- Buttons -->
            <div class="flex justify-between">
                <button type="submit" class="border border-red-keloola text-red-keloola px-4 py-2 rounded font-medium hover:bg-red-keloola hover:text-white-primary transition">SUBMIT</button>
                <button type="reset" class="text-red-500">DISCARD</button>
            </div>
        </form>
    </div>

    <!-- Artikel Populer -->
    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-bold mb-4">Artikel Populer</h2>
        <ul class="list-disc list-inside space-y-2">
            <li><a href="#" class="text-blue-600 hover:underline">Cara menggunakan sistem ticketing</a></li>
            <li><a href="#" class="text-blue-600 hover:underline">FAQ Sistem Keloola</a></li>
            <li><a href="#" class="text-blue-600 hover:underline">Tips Menulis Deskripsi Masalah</a></li>
        </ul>
    </div>
</div>

@endsection
<script src="{{ asset('dist/js/app.js') }}"></script>