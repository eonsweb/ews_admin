@extends('admin.app')

@section('title', 'Dashboard')

@section('page-heading', 'Dashboard')
@section('breadcrumb-item', 'Dashboard')
@section('breadcrumb-active', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/dataTables.bootstrap5.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/responsive.bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/buttons.bootstrap5.min.css') }} ">
@endpush


@section('main-content')
    <div class="container-fluid">
        
        
        <!-- Start::row-1 -->
        @include('admin.dashboard.current_sales')
        <!--End::row-1 -->

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                @include('admin.dashboard.previous')
            </div>
            <div class="col-lg-6 col-sm-6 col-md-6 col-xl-6">
                @include('admin.dashboard.metrics_summary')
            </div>
        </div>
        
        <!--End::row-1 -->

        {{-- Near Completion Agreements --}}
        <div class="row">
            @include('admin.dashboard.near_completion')
        </div>

        <!-- Start::row-1 -->
        @include('admin.dashboard.top_selling_product')
        <!--End::row-1 -->
       

    </div>

   



@endsection



@push('scripts')
    <script src="{{ asset('admin/assets/js/datatables/jquery-3.6.1.min.js') }}"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <!-- Datatables  -->
    <script src="{{ asset('admin/assets/js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/datatables/jszip.min.js') }}"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('admin/assets/js/datatables.js') }}"></script>
@endpush
