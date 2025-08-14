@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-xl font-semibold">Kategori Artikel</h2>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Kategori</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive table-bordered">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-black">
                    <th>Nama</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    function renderCategoryRows($categories, $allCategories, $parentId = null, $prefix = '') {
                        foreach ($categories->where('parent_id', $parentId) as $cat) {
                            echo '<tr>
                                    <td>' . ($parentId ? $prefix . e($cat->name) : '<strong>' . e($cat->name) . '</strong>') . '</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal'.$cat->id.'">Edit</button>
                                            <form action="'.route('categories.destroy', $cat).'" method="POST" onsubmit="return confirm(\'Hapus kategori ini?\')">
                                                '.csrf_field().method_field('DELETE').'
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                  </tr>';

                            // Modal Edit
                            echo '
                            <div class="modal fade" id="editModal'.$cat->id.'" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-lg shadow">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Kategori</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="'.route('categories.update', $cat).'" method="POST">
                                            '.csrf_field().method_field('PUT').'
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kategori</label>
                                                    <input type="text" name="name" class="form-control" value="'.e($cat->name).'" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Parent Kategori (opsional)</label>
                                                    <select name="parent_id" class="form-control">
                                                        <option value="">-- Tidak ada --</option>';
                                                        renderParentOptions($allCategories, '', null, $cat->id);
                            echo '              </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success">Update</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';

                            // Recursive untuk child
                            renderCategoryRows($allCategories, $allCategories, $cat->id, $prefix . '↳ ');
                        }
                    }

                    function renderParentOptions($categories, $prefix = '', $parent = null, $skipId = null) {
                        foreach ($categories->where('parent_id', $parent) as $cat) {
                            if ($cat->id != $skipId) {
                                echo '<option value="'.$cat->id.'">'.$prefix.$cat->name.'</option>';
                                renderParentOptions($categories, $prefix.'— ', $cat->id, $skipId);
                            }
                        }
                    }

                    renderCategoryRows($parentCategories, $allCategories);
                @endphp
            </tbody>
        </table>
    </div>

    <!-- Pagination + Per Page -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            {{ $parentCategories->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
        <div>
            <form method="GET" action="{{ route('categories.index') }}">
                <label for="perPage" class="me-2">Tampilkan</label>
                <select name="perPage" id="perPage" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                    <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span class="ms-1">per halaman</span>
            </form>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-lg shadow">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Kategori (opsional)</label>
                        <select name="parent_id" class="form-control">
                            <option value="">-- Tidak ada (Root) --</option>
                            @php renderParentOptions($allCategories); @endphp
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
