@include('admin.layout.head')

    <!-- Start Switcher -->
    @include('admin.layout.switcher')
    <!-- End Switcher -->


    <!-- Loader -->
    @include('admin.layout.loader')
    <!-- Loader -->

    <div class="page">
         <!-- app-header -->
         @include('admin.layout.appheader')
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
            @include('admin.layout.sidebar')
        <!-- End::app-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                    <h1 class="page-title fw-semibold fs-18 mb-0">@yield('page-heading','Empty')</h1>
                    <div class="ms-md-1 ms-0">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">@yield('breadcrumb-item','Dashboard')</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb-item','')</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- Page Header Close -->

                <!-- Start::row-1 -->
                <div class="row">
                    @yield('main-content')
                </div>
                <!--End::row-1 -->

            </div>
            <!-- Content Here-->
            @yield('main_content')
            <!-- End of Content Here-->
        </div>
        <!-- End::app-content -->

        
        <!--Search Modal Popup-->
            @include('admin.layout.search_modal_popup')
        <!--Search Modal Popup-->


        

        <!-- Footer Start -->
            @include('admin.layout.footer')
        <!-- Footer End -->

    </div>

    
    <!-- Scroll To Top -->
    @include('admin.layout.scroll_top')
    <!-- Scroll To Top -->

    {{-- Script --}}
    @include('admin.layout.script')