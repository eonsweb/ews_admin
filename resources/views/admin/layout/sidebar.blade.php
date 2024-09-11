<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">EONSWEB ADMIN</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
        <a class="nav-link" 
           href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt "></i>
            <span>Dashboard</span>
        </a>
    </li>

    

    <!-- Divider -->
    <hr class="sidebar-divider">

    
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                
                <a class=" collapse-item {{ Route::currentRouteName() == 'admin.users' ? 'active' : ''}}" href="{{ route('admin.users') }} ">Users</a>
                <a class="collapse-item {{ Route::currentRouteName() == 'admin.role.list' ? 'active' : ''}}" href="{{ route('admin.role.list') }}">Roles</a>
                <a class="collapse-item {{ Route::currentRouteName() == 'admin.permission.list' ? 'active' : ''}}" href="{{ route('admin.permission.list') }}">Permission</a>
                <a class="collapse-item" href="cards.html">Operation Log</a>
            </div>
        </div>
    </li>

    

    
    

    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    {{-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

</ul>