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
            <div class="col-xl-2">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Agreements Report</div>
                    </div>
                    <div class="card-body">
                        {{-- <ul class="nav nav-tabs flex-column nav-style-4" role="tablist">
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
                        </ul> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-10">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                           Monthly Agreement Report
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-basic" class="table table-bordered text-nowrap table-striped w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">#</th>
                                        <th>Month</th>
                                        <th>Total Agreements</th>
                                        <th>Total Principal</th>
                                        <th>Total Down Payments</th>
                                        <th>Total Paid</th>
                                        <th>Gross Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($monthlyAgreements as $key => $monthlyAgreement)
                                
                                        <tr>
                                            <td><span >{{ $key+1 }}</span></td>
                                            <td><span class="text-success">{{ $monthlyAgreement->month}}</span></td>
                                            <td><span class="text-primary">{{ $monthlyAgreement->total_agreements}}</span></td>
                                            <td><span class="text-success">GH₵ {{ number_format($monthlyAgreement->total_principal,2) }}</span></td>
                                            <td><span class="">GH₵ {{ number_format($monthlyAgreement->total_down_payment,2) }}</span></td>
                                            <td><span class="text-sucess">GH₵ {{ number_format($monthlyAgreement->total_paid,2) }}</span></td>
                                            <td><span class="text-sucess">GH₵ {{ number_format($monthlyAgreement->monthly_profit,2) }}</span></td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
