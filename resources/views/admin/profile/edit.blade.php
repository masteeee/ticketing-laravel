@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded p-4">
        <h1 class="text-2xl font-bold mb-4">EDIT PROFILE</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <div class="mb-2 d-flex justify-content-center">
                    <img id="profilePreview" 
                         src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('admin-template/img/undraw_profile.svg') }}"
                         alt="Foto Profil"
                         class="rounded-circle border"
                         width="120" height="120">
                </div>
                <input type="file" id="profile_photo_input" name="profile_photo" class="form-control" accept="image/*">
                <small class="text-muted">Pilih foto baru untuk mengganti. Anda bisa crop sebelum simpan.</small>
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
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Crop -->
<div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropModalLabel">Crop Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <img id="imageToCrop" style="max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="cropAndSave" class="btn btn-primary">Crop & Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
    let cropper;
    const input = document.getElementById('profile_photo_input');
    const modal = new bootstrap.Modal(document.getElementById('cropModal'));
    const image = document.getElementById('imageToCrop');
    const preview = document.getElementById('profilePreview');

    input.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
                modal.show();
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            preview: '.preview',
            background: false,
            movable: true,
            zoomable: true,
            rotatable: false,
            scalable: false,
            responsive: true
        });
    });

    document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    document.getElementById('cropAndSave').addEventListener('click', function() {
        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
            imageSmoothingQuality: 'high'
        });

        // Preview hasil crop
        preview.src = canvas.toDataURL();

        // Simpan hasil crop di input hidden
        canvas.toBlob(function(blob) {
            const file = new File([blob], "cropped_profile.png", { type: "image/png" });
            const container = new DataTransfer();
            container.items.add(file);
            input.files = container.files;
        });

        modal.hide();
    });
</script>
@endpush
