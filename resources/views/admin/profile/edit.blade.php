@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <h4>Edit Profil</h4>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <div class="mb-2">
                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('admin-template/img/undraw_profile.svg') }}"
                         alt="Foto Profil"
                         class="rounded-circle"
                         width="100" height="100">
                </div>
                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru (Opsional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
