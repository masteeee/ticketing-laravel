<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/keloola-logo.png') }}" alt="Keloola Logo" class="keloola-logo">
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

    @php
        $user = Auth::user();
        $userPermissions = $user && $user->role ? $user->role->permissions->pluck('name')->toArray() : [];
        function canView($perm, $userPermissions) {
            return in_array($perm, $userPermissions);
        }
    @endphp

    {{-- Departments --}}
    @if(canView('view departments', $userPermissions) || canView('view services', $userPermissions))
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#departmentSub" aria-expanded="false" aria-controls="rolePermissionSub">
            <i class="fas fa-fw fa-user-shield"></i>
            <span>Departments</span>
        </a>
        <div id="departmentSub" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(canView('view departments', $userPermissions))
                <a class="collapse-item" href="{{ route('admin.departments.index') }}">All Departments</a>
                @endif
                @if(canView('view services', $userPermissions))
                <a class="collapse-item" href="{{ route('admin.services.index') }}">All Services</a>
                @endif
            </div>
        </div>
    </li>
    @endif

@if(
    canView('view roles', $userPermissions) ||
    canView('view permissions', $userPermissions) ||
    canView('view users', $userPermissions) ||
    canView('create users', $userPermissions) ||
    canView('edit users', $userPermissions) ||
    canView('delete users', $userPermissions)
)
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rolePermissionSub" aria-expanded="false" aria-controls="rolePermissionSub">
        <i class="fas fa-fw fa-user-shield"></i>
        <span>Role & Permission</span>
    </a>
    <div id="rolePermissionSub" class="collapse">
        <div class="bg-white py-2 collapse-inner rounded">
            @if(canView('view roles', $userPermissions))
            <a class="collapse-item" href="{{ route('admin.roles.index') }}">Roles</a>
            @endif
            @if(canView('view permissions', $userPermissions))
            <a class="collapse-item" href="{{ route('admin.permissions.index') }}">Permissions</a>
            @endif
            @if(canView('view users', $userPermissions) || canView('create users', $userPermissions) || canView('edit users', $userPermissions) || canView('delete users', $userPermissions))
            <a class="collapse-item" href="{{ route('admin.users.index') }}">Users</a>
            @endif
        </div>
    </div>
</li>
@endif


    {{-- Knowledge Base --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#knowledgeBaseSub" aria-expanded="false" aria-controls="knowledgeBaseSub">
            <i class="fas fa-fw fa-book"></i>
            <span>Knowledge Base</span>
        </a>
        <div id="knowledgeBaseSub" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(canView('view categories', $userPermissions))
                <a class="collapse-item" href="{{ route('admin.categories.index') }}">Categories</a>
                @endif
                @if(canView('view articles', $userPermissions))
                <a class="collapse-item" href="{{ route('admin.articles.index') }}">Articles</a>
                @endif
            </div>
        </div>
    </li>

    {{-- Ticketing --}}
    @if(canView('view tickets', $userPermissions))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.tickets.index') }}">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Manajemen Ticketing</span>
        </a>
    </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggle --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

{{-- Script --}}
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

{{-- Tambahkan Style Logo --}}
<style>
    .keloola-logo {
        height: 30px;
        transition: all 0.2s ease;
    }

    .sidebar.toggled .keloola-logo {
        height: 15px;
    }

    .collapse-inner {
        background-color: #fff !important;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .collapse-item {
        color: #3a3b45 !important;
        padding: 0.5rem 1rem;
        display: block;
        text-decoration: none;
        border-radius: 0.35rem;
        margin: 0 0.25rem;
    }

    .collapse-item:hover {
        background-color: #eaecf4;
        color: #3a3b45 !important;
        text-decoration: none;
    }

    .collapse.show {
        display: block !important;
    }
</style>
