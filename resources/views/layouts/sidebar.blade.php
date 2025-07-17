<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('assets/keloola-logo.png') }}" alt="Keloola Logo" style="height: 30px;">
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Departments --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.departments.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Departments</span>
        </a>
    </li>

    {{-- Tambahkan menu lain di sini jika diperlukan --}}
    {{-- Contoh:
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.categories.index') }}">
            <i class="fas fa-fw fa-list"></i>
            <span>Categories</span>
        </a>
    </li>
    --}}

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggle --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
