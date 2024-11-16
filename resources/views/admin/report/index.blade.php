@extends('admin.app')

@section('title', 'Daily Payment Report')
@section('page-heading', 'Report')
@section('breadcrumb-item', 'Report')
@section('breadcrumb-active', 'Daily Payment Report')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/dataTables.bootstrap5.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/responsive.bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/buttons.bootstrap5.min.css') }} ">
@endpush

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Payments</div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs flex-column nav-style-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') === 'agents-daily-payments' ? 'active' : '' }}" 
                                   data-bs-toggle="tab" 
                                   href="{{ route('admin.payment_report', ['tab' => 'agents-daily-payments']) }}">Agents Daily Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') === 'total-daily-payments' ? 'active' : '' }}" 
                                   data-bs-toggle="tab" 
                                   href="{{ route('admin.payment_report', ['tab' => 'total-daily-payments']) }}">Total Daily Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') === 'monthly-payments' ? 'active' : '' }}" 
                                   data-bs-toggle="tab" 
                                   href="{{ route('admin.payment_report', ['tab' => 'monthly-payments']) }}">Monthly Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('tab') === 'yearly-payments' ? 'active' : '' }}" 
                                   data-bs-toggle="tab" 
                                   href="{{ route('admin.payment_report', ['tab' => 'yearly-payments']) }}">Yearly Payments</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @php
                // Define the tab and view map
                $tab = request('tab') ?? 'agents-daily-payments'; // Set a default tab
                $viewMap = [
                    'total-daily-payments' => 'total_daily_payment',
                    'monthly-payments' => 'monthly_payment',
                    'yearly-payments' => 'yearly_payment',
                    'agents-daily-payments' => 'agents_daily_payment'
                ];

                // Log the current tab and the view map
                \Log::info('Current tab: ' . $tab);
                \Log::info('View map: ' . json_encode($viewMap));
            @endphp

            <div class="col-xl-9">
                @if (array_key_exists($tab, $viewMap))
                    @include('admin.report.' . $viewMap[$tab])
                @else
                    @php
                        \Log::error('Tab not found in view map: ' . $tab);
                    @endphp
                    <div class="alert alert-danger">Error loading report. Please try again later.</div>
                @endif
            </div>
        </div>
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
