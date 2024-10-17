@extends('admin.app')

@section('title', 'Product')

@section('page-heading', 'Products')
@section('breadcrumb-item', 'Product')
@section('breadcrumb-active', 'Product')

@push('styles')
    <!-- Datatable -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/dataTables.bootstrap5.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/responsive.bootstrap.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/datatables/buttons.bootstrap5.min.css') }} ">

    <!-- Select2 -->
    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/select2.min.css') }} "> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush


@section('main-content')
    <div class="container-fluid">



        <!-- Start::row-1 -->
        <div class="row">

            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Number of Products: <span class="text-danger">{{ $products->count() }}</span>
                        </div>
                        <div class=" ms-auto">
                            <a href="{{ route('admin.product.add') }}" class="btn btn-secondary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#productNewModal"><i class='bx bx-plus'></i>New
                                Product
                            </a>

                            <!-- Import Excel or Csv File data -->
                            <a href="{{ route('admin.products.import') }}" class="btn btn-success btn-sm"
                                data-bs-toggle="modal" data-bs-target="#productImportModal"><i
                                    class="bi bi-file-earmark-excel"></i> Import From Excel
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
                                            <h6 class="text-dark">Product Name</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Category</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Sale Price (GH₵)</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark">Stock Price (GH₵)</h6>
                                        </th>
                                        <th>
                                            <h6 class="text-dark " style="transform: scale(1.2);"><i
                                                    class="bi bi-percent"></i></h6>
                                        </th>
                                        <th>Profit</th>


                                        <th style="width: 10%;">
                                            <h6 class="text-dark"><i class='bx bxs-bolt'></i></h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <h6 class="h6">{{ $product->name }}</h6>
                                            </td>
                                            <td><span
                                                    class="badge bg-light text-default">{{ $product->category->name }}</span>
                                            </td>
                                            <td>GH₵{{ number_format($product->sale_price, 2) }}</td>
                                            <td>
                                                {{ $product->stock_price != 0 ? 'GH₵' . number_format($product->stock_price, 2) : 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $product->stock_price != 0 ? ($product->sale_price - $product->stock_price)/100 * 100 . '%' : 'N/A' }}
                                            </td>
                                            <th> {{ $product->stock_price != 0 ? 'GH₵' . ($product->sale_price - $product->stock_price) : 'N/A' }}
                                            </th>

                                            <td><a href="{{ route('admin.product.edit', $product->id) }}"
                                                    class="btn btn-icon rounded-pill btn-sm  btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#productEditModal-{{ $product->id }}"
                                                    data-id="{{ $product->id }}"
                                                    data-category-id="{{ $product->category_id }}" aria-hidden="true">
                                                    <i class="bi bi-pencil-square"></i></a>

                                                <a href="{{ route('admin.product.delete', $product->id) }}"
                                                    class="btn btn-icon rounded-pill btn-sm  btn-danger"><i
                                                        class="bi bi-trash-fill"></i>
                                                </a>
                                            </td>
                                            <!-- Include the modal with a unique ID for each product -->
                                            @include('admin.product.edit', ['product' => $product])
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
    @include('admin.product.add')

    <!-- Add Menu Modal -->
    @include('admin.product.import')




@endsection


@if (session('modal') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('productNewModal'));
            modal.show();
        });
    </script>
@endif

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
    
    <script>
       


    $(document).ready(function() {
        // New Product Modal
        $('#productNewModal').on('shown.bs.modal', function() {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#productNewModal')
            });
        });

        // Edit Product Modal
        // Use event delegation to listen for when any product edit modal is opened
        $(document).on('shown.bs.modal', '[id^=productEditModal-]', function(event) {
            // Get the button that triggered the modal
            var button = $(event.relatedTarget); // Button that triggered the modal

            // Extract the product ID and category ID from the button
            var productId = button.data('id');
            var categoryId = button.data('category-id');

            // Populate the hidden input field with the product ID
            $(this).find('#editProductId').val(productId);
            
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
