<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/keloola-logo.png') }}" alt="Keloola Logo" style="height: 30px;">
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Departments (Hanya untuk admin) --}}
    @if(Auth::user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.departments.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Departments</span>
        </a>
    </li>
    @endif

    {{-- Knowledge Base --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#knowledgeBaseSub" aria-expanded="false" aria-controls="knowledgeBaseSub">
            <i class="fas fa-fw fa-book"></i>
            <span>Knowledge Base</span>
        </a>
        <div id="knowledgeBaseSub" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(Auth::user()->role === 'admin')
                <a class="collapse-item" href="{{ route('admin.categories.index') }}">Categories</a>
                @endif
                <a class="collapse-item" href="{{ route('admin.articles.index') }}">Articles</a>
            </div>
        </div>
    </li>

    {{-- Ticketing --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.tickets.index') }}">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Manajemen Ticketing</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggle (Collapse Button) --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
