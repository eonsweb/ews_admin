<header class="app-header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo"> 
                        <img src=" {{ asset('admin/assets/images/brand-logos/desktop-logo.png ')}}" alt="logo" class="desktop-logo">
                        <img src=" {{ asset('admin/assets/images/brand-logos/toggle-logo.png ')}}" alt="logo" class="toggle-logo">
                        <img src=" {{ asset('admin/assets/images/brand-logos/desktop-dark.png ')}}" alt="logo" class="desktop-dark">
                        <img src=" {{ asset('admin/assets/images/brand-logos/toggle-dark.png ')}}" alt="logo" class="toggle-dark">
                        <img src=" {{ asset('admin/assets/images/brand-logos/desktop-white.png ')}}" alt="logo" class="desktop-white">
                        <img src=" {{ asset('admin/assets/images/brand-logos/toggle-white.png ')}}" alt="logo" class="toggle-white"> 
                    </a>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element - Toggler -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">

            @include('admin.layout.appheader.search')
            <!-- End::header-element -->

            

            <!-- Start::header-element: Theme Mode -->

                @include('admin.layout.appheader.theme-color')
            
            <!-- End::header-element -->
            
            <!-- Start::header-element: Cart Section -->
                @include('admin.layout.appheader.cart')
            <!-- End::header-element -->

            <!-- Start::header-element: Notification Section -->
                @include('admin.layout.appheader.notification')
            <!-- End::header-element -->

            <!-- Start::header-element : Notification Toggler -->
                @include('admin.layout.appheader.other-apps')
            <!-- End::header-element -->

            <!-- Start::header-element : Fullscreen Toggler -->
            <div class="header-element header-fullscreen">
                <!-- Start::header-link -->
                <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                    <i class="bx bx-fullscreen full-screen-open header-link-icon"></i>
                    <i class="bx bx-exit-fullscreen full-screen-close header-link-icon d-none"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

            @php
                    $admin = Auth::guard('admin')->id();
                    $admin_profile = App\Models\AdminUser::find($admin)->first();
            @endphp

            <!-- Start::header-element : User Info Section -->
            <div class="header-element">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            @if (empty($admin_profile->photo))
                                <i class="ti ti-user-circle fs-50 me-2 op-7"></i>   
                            @else
                                          
                                <img src="{{ url('admin/assets/images/uploads/'.$admin_profile->photo) }}" alt="img" width="32" height="32" class="rounded-circle">
                            @endif
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{$admin_profile->name}}</p>
                            <span class="op-7 fw-normal d-block fs-11">{{$admin_profile->role}}</span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex" href="{{ route('admin.profile') }}"><i class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile</a></li>
                    <li><a class="dropdown-item d-flex" href="mail.html"><i class="ti ti-inbox fs-18 me-2 op-7"></i>Inbox <span class="badge bg-success-transparent ms-auto">25</span></a></li>
                    <li><a class="dropdown-item d-flex border-block-end" href="to-do-list.html"><i class="ti ti-clipboard-check fs-18 me-2 op-7"></i>Task Manager</a></li>
                    <li><a class="dropdown-item d-flex" href="mail-settings.html"><i class="ti ti-adjustments-horizontal fs-18 me-2 op-7"></i>Settings</a></li>
                    <li><a class="dropdown-item d-flex border-block-end" href="javascript:void(0);"><i class="ti ti-wallet fs-18 me-2 op-7"></i>Bal: $7,12,950</a></li>
                    <li><a class="dropdown-item d-flex" href="chat.html"><i class="ti ti-headset fs-18 me-2 op-7"></i>Support</a></li>
                    <li><a class="dropdown-item d-flex" href="{{ route('admin.logout')}}"><i class="ti ti-logout fs-18 me-2 op-7"></i>Log Out</a></li>
                </ul>
            </div>  
            <!-- End::header-element -->

            <!-- Start::header-element : Switcher -->
            {{-- <div class="header-element">
                    <!-- Start::header-link|switcher-icon -->
                    <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                        <i class="bx bx-cog header-link-icon"></i>
                    </a>
                    <!-- End::header-link|switcher-icon -->
                </div> 
            --}}

            <!-- End::header-element -->

        </div>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>