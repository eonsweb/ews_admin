@extends('admin.app')

@section('title', 'Agreement')

@section('page-heading', 'Hire Purchase Agreements')
@section('breadcrumb-item', 'Hire Purchase')
@section('breadcrumb-active', 'Agreement')

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
                            
                            Number of Agreements: <span class="text-danger">{{ $agreements->count() }}</span>
                            
                            
                            <a href="{{ route('admin.agreement.add') }}" class="btn btn-secondary btn-sm ms-5"><i class='bx bx-plus'></i>New
                                Agreement
                            </a>
                        </div>
                        <div class=" ms-auto">
                            
                            <a href="{{ route('admin.payments') }}" class="btn btn-primary btn-sm "><i class='bx bx-arrow-back'></i>Payments
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap table-hover w-100">
                                <thead class="bg-success text-light">
                                    <tr>

                                        <th style="width: 5%;">
                                            #
                                        </th>
                                        <th>
                                            Customer Info
                                        </th>
                                        <th>
                                            Transaction ID
                                        </th>
                                        <th>
                                            Product
                                        </th>
                                        <th>
                                            Principal
                                        </th>
                                        <th>
                                            Down Payment
                                        </th>
                                        <th>Total Paid</th>
                                        <th>
                                            Balance
                                        </th>
                                        <th>
                                            Employee
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Start Date
                                        </th>
                                        <th>Count Down</th>

                                        <th style="width: 10%;">
                                            <h6 class="text-dark"><i class='bx bxs-bolt'></i></h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agreements as $key => $agreement)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><div class="row">

                                                <div class="text-muted">{{$agreement->customer->phone}}</div> 
                                               <h6>{{ $agreement->customer->name }}</h6> 
                                            </div>
                                            </td>
                                            <td><span class="text-success">{{ $agreement->transaction_id }}</span></td>
                                            <td>{{$agreement->product->name}}</td>
                                            <td>GH₵ {{ number_format($agreement->principal, 2) }}</td>
                                            <td class="text-success">
                                                GH₵ {{ number_format($agreement->down_payment,2) }}
                                            </td>
                                            <td class="text-primary">
                                                GH₵ {{ number_format($agreement->total_paid,2) }}
                                            </td>
                                            <td class="text-danger">
                                                GH₵ {{ number_format($agreement->balance,2) }}
                                            </td>
                                            <td>
                                               {{$agreement->employee->name}}
                                            </td>
                                            <td >
                                                @if ($agreement->status == 'completed')
                                                    <span class="badge bg-success-transparent">
                                                        {{$agreement->status}}
                                                    </span>
                                                @elseif($agreement->status == 'active')
                                                    <span class="badge bg-warning-transparent">
                                                        {{$agreement->status}}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-transparent">
                                                        {{$agreement->status}}
                                                    </span>
                                                @endif
                                              
                                            </td>
                                            <th>{{ \Carbon\Carbon::parse($agreement->start_date)->format('Y-m-d') }}</th>
                                            <th>
                                                @if (is_numeric($agreement->countDown) && $agreement->countDown > 0)
                                                    <span class="badge rounded-pill bg-warning">{{ number_format($agreement->countDown, 0) . ' days' }}</span>
                                                @elseif ($agreement->countDown === 'stop')
                                                    <span class="badge rounded-pill bg-success text-white">Paid</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger">Expired</span>
                                                @endif
                                            </th>
                                        
                                            <td><a href="{{ route('admin.agreement.edit', $agreement->id) }}"
                                                    class="btn btn-icon  rounded-pill btn-sm  btn-success-light"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#agreementEditModal-{{ $agreement->id }}"
                                                    data-id="{{ $agreement->id }}"
                                                    data-category-id="{{ $agreement->category_id }}" aria-hidden="true">
                                                    <i class="bi bi-pencil-square"></i></a>

                                                <a href="{{ route('admin.agreement.delete', $agreement->id) }}"
                                                    class="btn btn-icon  rounded-pill btn-sm  btn-danger-light"><i
                                                        class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                            <!-- Include the modal with a unique ID for each agreement -->
                                            @include('admin.hire_purchase.agreements.edit', ['agreement' => $agreement])
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
    {{-- @include('admin.hire_purchase.agreements.add') --}}

 




@endsection

{{-- 
@if (session('modal') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('agreementNewModal'));
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
        // New Agreement Modal
        $('#agreementNewModal').on('shown.bs.modal', function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#agreementNewModal')
            });
        });

        // Edit Agreement Modal
        // Use event delegation to listen for when any agreement edit modal is opened
        $(document).on('shown.bs.modal', '[id^=agreementEditModal-]', function(event) {
            // Get the button that triggered the modal
            var button = $(event.relatedTarget); // Button that triggered the modal

            // Extract the agreement ID and category ID from the button
            var agreementId = button.data('id');
            var categoryId = button.data('category-id');

            // Populate the hidden input field with the agreement ID
            $(this).find('#editAgreementId').val(agreementId);
            
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
