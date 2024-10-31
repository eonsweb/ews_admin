@extends('admin.app')

@section('title', 'Customer Payments Summary')

@section('page-heading', 'Customer Payments Summary')
@section('breadcrumb-item', 'Customer Payments Summary')
@section('breadcrumb-active', 'Customer Payments Summary')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/dataTables.bootstrap5.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/responsive.bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/buttons.bootstrap5.min.css') }} ">
@endpush


@section('main-content')
    <div class="container-fluid">



        <!-- Start::row-1 -->
        <div class="row">

            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                          Number of Transactions: <span class="text-danger">{{$paymentsSummaries->count()}}</span>
                        </div>
                        

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap  table-hover w-100 w-100">
                                <thead>
                                    <tr>

                                        <th style="width: 10%;">#</th>
                                        <th>Transaction ID</th>
                                        <th>Customer Info</th>
                                        <th>Product</th>
                                        <th>Product Price</th>
                                        <th>Total Paid</th>
                                        <th>Balance</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentsSummaries as $key => $paymentsSummary)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><span class="text-success">{{ $paymentsSummary->agreement->transaction_id }}</span></td>
                                            <td>{{ $paymentsSummary->agreement->customer->name ." - ".$paymentsSummary->agreement->customer->phone }}</td>
                                            <td>{{ $paymentsSummary->agreement->product->name }}</td>
                                            <td>{{ $paymentsSummary->agreement->product->sale_price }}</td>
                                            <td>{{ $paymentsSummary->total_paid }}</td>
                                            <td>{{  $paymentsSummary->agreement->product->sale_price - $paymentsSummary->total_paid }}</td>
                                            
                                          
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
