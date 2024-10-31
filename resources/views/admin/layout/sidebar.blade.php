<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('admin/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
            <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                class="desktop-dark">
            <img src="{{ asset('admin/assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                class="toggle-dark">
            <img src="{{ asset('admin/assets/images/brand-logos/desktop-white.png') }}" alt="logo"
                class="desktop-white">
            <img src="{{ asset('admin/assets/images/brand-logos/toggle-white.png') }}" alt="logo"
                class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                
                <!-- Start::slide -->
                <li class="slide">
                    <a href="{{ route('admin.dashboard') }}"
                        class="side-menu__item {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
                        <i class="ri-dashboard-fill side-menu__icon"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class='bx bx-money-withdraw side-menu__icon'></i>
                        
                        <span class="side-menu__label">Hire Purchase</span>

                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                    <ul class="slide-menu child1 mega-menu">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Hire Purchase</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.agreements') }}" class="side-menu__item">Agreement</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.payments') }}" class="side-menu__item">Daily Payments</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.payment.records') }}" class="side-menu__item"> Payment Records</a>
                        </li>
                    </ul>
                </li>
                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class='bx bxs-bank side-menu__icon'></i>
                        <span class="side-menu__label">SUSU Collection</span>
                        
                        <i class="fe fe-chevron-right side-menu__angle"></i></a>
                    <ul class="slide-menu child2">
                        <li class="slide">
                            <a href="mail.html" class="side-menu__item">Susu Agreement</a>
                        </li>
                        <li class="slide">
                            <a href="mail-settings.html" class="side-menu__item">Deposit</a>
                        </li>
                    </ul>
                </li>
                <li class="slide">
                    <a href="{{route('admin.employees')}}"
                        class="side-menu__item {{ Route::currentRouteName() === 'admin.employees' ? 'active' : ''}}">
                        
                        <i class="bx bx-user side-menu__icon"></i>
                        <span class="side-menu__label">Employee</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{route('admin.customers')}}"
                        class="side-menu__item {{ Route::currentRouteName() === 'admin.customers' ? 'active' : ''}}">
                        
                        <i class="bi bi-people-fill side-menu__icon"></i>
                        <span class="side-menu__label">Customer</span>
                    </a>
                </li>
                <li class="slide">
                    <a href="{{route('admin.categories')}}"
                        class="side-menu__item {{ Route::currentRouteName() === 'admin.categories' ? 'active' : ''}}">
                        
                        <i class="bx bx-category-alt side-menu__icon"></i>
                        <span class="side-menu__label">Category</span>
                    </a>
                </li>
                
                <li class="slide">
                    <a href="{{route('admin.products')}}"
                        class="side-menu__item">
                        <i class="bx bxl-product-hunt side-menu__icon"></i>
                        <span class="side-menu__label">Product</span>
                    </a>
                </li>
                
                <!-- End::slide -->






            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>
