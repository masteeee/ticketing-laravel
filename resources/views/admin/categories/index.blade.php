@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="bg-white p-4 rounded shadow-sm">
        <div class="d-flex justify-between items-center mb-4">
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
                    <tr>
                        <th>Nama</th>
                        <th style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        function renderCategoryRows($categories, $parentId = null, $prefix = '') {
                            foreach ($categories->where('parent_id', $parentId) as $cat) {
                                echo '<tr>
                                        <td>' . $prefix . e($cat->name) . '</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal'.$cat->id.'">Edit</button>
                                                <form action="'.route('admin.categories.destroy', $cat).'" method="POST" onsubmit="return confirm(\'Hapus kategori ini?\')">
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
                                            <form action="'.route('admin.categories.update', $cat).'" method="POST">
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
                                                            renderParentOptions($categories, '', null, $cat->id);
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

                                renderCategoryRows($categories, $cat->id, $prefix . '↳ ');
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

                        renderCategoryRows($categories);
                    @endphp
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $categories->links() }}
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
            <form action="{{ route('admin.categories.store') }}" method="POST">
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
                            @php renderParentOptions($categories); @endphp
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
