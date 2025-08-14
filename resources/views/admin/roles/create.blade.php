@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Role</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Role</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Permissions</label>
            <div>
                <div class="mb-2">
                    <input type="checkbox" id="checkAll" onclick="toggleAllPermissions(this)">
                    <label for="checkAll"><strong>Centang Semua Permission</strong></label>
                </div>
                @foreach($permissions as $group => $perms)
                    <div class="">
                        <input type="checkbox" class="check-section" id="checkSection_{{ $group }}" onclick="toggleSection('{{ $group }}', this)">
                        <label for="checkSection_{{ $group }}"><strong>{{ ucfirst($group) }}</strong></label>
                    </div>
                    <div class="row mb-4">
                        @foreach($perms as $perm)
                            <div class="col-12 col-md-6 col-lg-4 mb-1">
                                <div class="form-check">
                                    <input class="form-check-input perm-{{ $group }} custom-red-checkbox" type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}">
                                    <label class="form-check-label" for="perm_{{ $perm->id }}">{{ $perm->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="flex justify-content-end">
            <button class="btn btn-danger mb-4">Simpan</button>
        </div>
    </form>
</div>
<script>
function toggleAllPermissions(source) {
    const all = document.querySelectorAll('.form-check-input');
    all.forEach(cb => cb.checked = source.checked);
    // Section checkboxes
    document.querySelectorAll('.check-section').forEach(cb => cb.checked = source.checked);
}
function toggleSection(group, source) {
    const section = document.querySelectorAll('.perm-' + group);
    section.forEach(cb => cb.checked = source.checked);
}
</script>
@endsection 