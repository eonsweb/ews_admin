@extends('admin.app')

@section('title', 'Customer')

@section('page-heading', 'Customers')
@section('breadcrumb-item', 'Customer')
@section('breadcrumb-active', 'Customer')

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
                          Number of Customers: <span class="text-danger">{{$customers->count()}}</span>
                        </div>
                        <div class=" ms-auto">
                            <a href="{{ route('admin.customer.add') }}" class="btn btn-secondary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#customerNewModal"><i class='bx bx-plus'></i>New
                                Customer
                            </a>

                            <!-- Import Excel or Csv File data -->
                            <a href="{{ route('admin.customers.import') }}" class="btn btn-success btn-sm"
                                data-bs-toggle="modal" data-bs-target="#customerImportModal"><i
                                    class="bi bi-file-earmark-excel"></i> Import From Excel
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file-export" class="table table-bordered text-nowrap  table-hover w-100 w-100">
                                <thead>
                                    <tr>

                                        <th style="width: 10%;">#</th>
                                        <th>Name</th>
                                        <th>Phone no.</th>
                                        <th>ID Type</th>
                                        <th>ID Number</th>
                                        <th style="width: 10%;"><i class='bx bxs-bolt'></i>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $key => $customer)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><a href="{{route('admin.customer.show',$customer->id)}}">{{ $customer->name }}</a></td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->id_type ?? 'N/A' }}</td>
                                            <td>{{ $customer->id_number ?? 'N/A' }}</td>
                                            <td><a href="{{ route('admin.customer.edit', $customer->id) }}"
                                                    class="btn btn-icon rounded-pill btn-sm  btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#customerEditModal-{{ $customer->id }}"
                                                    aria-hidden="true"
                                                >
                                                <i class="bi bi-pencil-square"></i></a>

                                                <a href="{{ route('admin.customer.delete', $customer->id) }}"
                                                    class="btn btn-icon rounded-pill btn-sm  btn-danger"><i
                                                        class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                            <!-- Include the modal with a unique ID for each customer -->
                                            @include('admin.customers.edit', ['customer' => $customer])
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
    @include('admin.customers.add')

    <!-- Add Menu Modal -->
    @include('admin.customers.import')




@endsection


@if (session('modal') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('customerNewModal'));
            modal.show();
        });
    </script>
@endif

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
