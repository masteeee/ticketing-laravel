@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Kategori</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Kategori (opsional)</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Tidak ada (Root) --</option>
                @php
                    function renderCategoryOptions($categories, $prefix = '', $parent = null) {
                        foreach($categories->where('parent_id', $parent) as $cat) {
                            echo '<option value="'.$cat->id.'">'.$prefix.$cat->name.'</option>';
                            renderCategoryOptions($categories, $prefix.'— ', $cat->id);
                        }
                    }
                    renderCategoryOptions($categories);
                @endphp
            </select>
        </div>
        <button class="btn btn-danger">Simpan</button>
    </form>
</div>
@endsection
