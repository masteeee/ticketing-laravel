@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded p-4 text-center">
        <h1 class="text-2xl font-bold mb-4">Profile Admin</h1>

        <!-- Foto Profil di Tengah -->
        <div class="mb-4 d-flex justify-content-center">
            <img src="{{ $user->profile_photo 
                ? asset('storage/' . $user->profile_photo) . '?v=' . time() 
                : asset('admin-template/img/undraw_profile.svg') }}" 
                 class="rounded-circle border"
                 width="120"
                 height="120"
                 alt="Foto Profil">
        </div>

        <!-- Info User -->
        <table class="table table-bordered text-left">
            <tr>
                <th>Nama</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Dibuat pada</th>
                <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@endsection
