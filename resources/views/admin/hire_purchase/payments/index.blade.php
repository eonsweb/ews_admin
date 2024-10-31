@extends('admin.app')

@section('title', 'Payments')

@section('page-heading', 'Hire Purchase Payments')
@section('breadcrumb-item', 'Hire Purchase')
@section('breadcrumb-active', 'Payments')

@push('styles')
    <!-- Datatable -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/dataTables.bootstrap5.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/responsive.bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/buttons.bootstrap5.min.css') }} ">

    <!-- Select2 -->
    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/select2.min.css') }} "> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    {{-- Date Picker --}}
    <link rel="stylesheet" href="{{asset('admin/assets/libs/flatpickr/flatpickr.min.css')}}">
@endpush


@section('main-content')
    <div class="container-fluid">



        <!-- Start::row-1 -->
        <div class="row">

            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                        Total No. of Payments: <span class="text-primary">{{ $payments->count() }}</span>
                        
                        <a href="{{ route('admin.payment.add') }}" class="btn btn-secondary btn-sm ms-5"><i class='bx bx-plus'></i>New
                            Payment
                        </a>
                        </div>
                        <div class=" ms-auto">
                            <a href="{{ route('admin.agreements') }}" class="btn btn-primary btn-sm ms-5">
                                <i class='bx bx-arrow-back'></i>
                                Agreements
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap table-hover w-100">
                                <thead class="bg-success text-light">
                                    <tr>

                                        <th style="width: 5%;">
                                            <h6 class="text-light">#</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Payment ID</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Customer Info</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Amt Paid(GH₵)</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Total Paid(GH₵)</h6>
                                        </th>
                                        
                                        <th>
                                            <h6 class="text-dark">Employee</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Date</h6>
                                        </th>


                                        <th style="width: 10%;">
                                            <h6 class="text-dark"><i class='bx bxs-bolt'></i></h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $key => $payment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <h6 class="h6">{{ $payment->agreement->transaction_id }}</h6>
                                            </td>
                                            
                                            <td>{{$payment->customer->name}}</td>
                                            <td class="text-success">GH₵ {{ number_format($payment->amount_paid, 2) }}</td>
                                            <td class="text-danger">GH₵ {{ number_format($payment->cumulative_total_paid, 2) }}</td>
                                            <td>
                                               {{$payment->employee->name}}
                                            </td>
                                            <th>{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d') }}</th>

                                            <td><a href="{{ route('admin.payment.edit', $payment->id) }}"
                                                    class="btn btn-icon rounded-pill btn-sm  btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#paymentEditModal-{{ $payment->id }}"
                                                    data-id="{{ $payment->id }}"
                                                    data-category-id="{{ $payment->category_id }}" aria-hidden="true">
                                                    <i class="bi bi-pencil-square"></i></a>

                                                <a href="{{ route('admin.payment.delete', $payment->id) }}"
                                                    class="btn btn-icon rounded-pill btn-sm  btn-danger"><i
                                                        class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                            <!-- Include the modal with a unique ID for each payment -->
                                            {{-- @include('admin.hire_purchase.payment.edit', ['payment' => $payment]) --}}
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

    <!-- Add Menu Modal -->
    {{-- @include('admin.hire_purchase.payments.add') --}}

 




@endsection

{{-- 
@if (session('modal') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('paymentNewModal'));
            modal.show();
        });
    </script>
@endif --}}

@push('scripts')
    <!-- Jquery -->
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

    <!-- Select 2 -->
    <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{ asset('admin/assets/js/date&time_pickers.js')}}"></script>
    
    <script>
       


    $(document).ready(function() {
        // New Payment Modal
        $('#paymentNewModal').on('shown.bs.modal', function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#paymentNewModal')
            });
        });

        // Edit Payment Modal
        // Use event delegation to listen for when any payment edit modal is opened
        $(document).on('shown.bs.modal', '[id^=paymentEditModal-]', function(event) {
            // Get the button that triggered the modal
            var button = $(event.relatedTarget); // Button that triggered the modal

            // Extract the payment ID and category ID from the button
            var paymentId = button.data('id');
            var categoryId = button.data('category-id');

            // Populate the hidden input field with the payment ID
            $(this).find('#editPaymentId').val(paymentId);
            
            // Set the selected category in the dropdown
            $(this).find('#editCategorySelect').val(categoryId).trigger('change'); // Set category and trigger change

            // Initialize Select2 for the category dropdown
            $(this).find('#editCategorySelect').select2({
                dropdownParent: $(this) // Specify the parent for dropdown
            });
        });
    });

    </script>
@endpush
