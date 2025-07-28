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
        function canSidebar($perm, $userPermissions) {
            return in_array($perm, $userPermissions);
        }
    @endphp

    {{-- Departments --}}
    @if(canSidebar('view departments', $userPermissions))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.departments.index') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Departments</span>
        </a>
    </li>
    @endif

@if(
    canSidebar('view roles', $userPermissions) ||
    canSidebar('view permissions', $userPermissions) ||
    canSidebar('view users', $userPermissions) ||
    canSidebar('create users', $userPermissions) ||
    canSidebar('edit users', $userPermissions) ||
    canSidebar('delete users', $userPermissions)
)
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rolePermissionSub" aria-expanded="false" aria-controls="rolePermissionSub">
        <i class="fas fa-fw fa-user-shield"></i>
        <span>Role & Permission</span>
    </a>
    <div id="rolePermissionSub" class="collapse" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            @if(canSidebar('view roles', $userPermissions))
            <a class="collapse-item" href="{{ route('admin.roles.index') }}">Roles</a>
            @endif
            @if(canSidebar('view permissions', $userPermissions))
            <a class="collapse-item" href="{{ route('admin.permissions.index') }}">Permissions</a>
            @endif
            @if(canSidebar('view users', $userPermissions) || canSidebar('create users', $userPermissions) || canSidebar('edit users', $userPermissions) || canSidebar('delete users', $userPermissions))
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
        <div id="knowledgeBaseSub" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(canSidebar('view categories', $userPermissions))
                <a class="collapse-item" href="{{ route('admin.categories.index') }}">Categories</a>
                @endif
                @if(canSidebar('view articles', $userPermissions))
                <a class="collapse-item" href="{{ route('admin.articles.index') }}">Articles</a>
                @endif
            </div>
        </div>
    </li>

    {{-- Ticketing --}}
    @if(canSidebar('view tickets', $userPermissions))
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
</style>
