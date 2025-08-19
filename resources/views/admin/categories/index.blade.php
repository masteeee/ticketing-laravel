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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('categories.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Cari Kategori</label>
                        <input type="text" name="search" class="form-control" placeholder="Masukkan nama kategori..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Filter by Parent</label>
                        <select name="parent_filter" class="form-control">
                            <option value="">-- Semua Kategori --</option>
                            <option value="root" {{ request('parent_filter') === 'root' ? 'selected' : '' }}>Root Categories (Tanpa Parent)</option>
                            @foreach($allCategories->whereNull('parent_id') as $parent)
                                <option value="{{ $parent->id }}" {{ request('parent_filter') == $parent->id ? 'selected' : '' }}>
                                    Children of: {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive table-bordered">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-black">
                    <th style="width: 5%;">No</th>
                    <th>Nama</th>
                    <th>Parent</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parentCategories as $index => $category)
                <tr>
                    <td>{{ ($parentCategories->currentPage() - 1) * $parentCategories->perPage() + $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">Edit</button>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-lg shadow">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('categories.update', $category) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Kategori</label>
                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Parent Kategori (opsional)</label>
                                        <select name="parent_id" class="form-control">
                                            <option value="">-- Tidak ada --</option>
                                            @foreach($allCategories->where('id', '!=', $category->id) as $cat)
                                                <option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success">Update</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $parentCategories->links() }}
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
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
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
