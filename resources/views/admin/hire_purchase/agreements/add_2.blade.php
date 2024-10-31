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
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.css') }}">
@endpush


@section('main-content')
    <div class="container-fluid">



        <!-- Start::row-1 -->
        <div class="row">
            <div id="agreementRows">

                <div class="card custom-card">
                    <div class="card-header d-sm-flex d-block">
                        <div class="card-title">
                            <div class=" ms-auto">
                                <button class="btn btn-secondary btn-sm" onclick="addAgrrementRow()"><i
                                        class="bx bx-plus"></i>Add New Row</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <form id="agreementForm" action="{{ route('admin.agreement.store') }}" method="POST">
                            @csrf

                            @if (old('agreements'))

                                @foreach (old('agreements') as $index => $oldAgreement)
                                    <div class="row py-2" id="agreementFormRow{{ $index }}">
                                        <div class="col-xxl-4 col-xl-12">
                                            <!--Select Customer -->
                                            <div class="mb-3">
                                                <label for="customer_id{{ $index }}" class="form-label">Select
                                                    Customer</label>
                                                <select
                                                    class="js-example-basic-single @error('agreements.' . $index . '.customer_id') is-invalid @enderror"
                                                    id="customer_id{{ $index }}"
                                                    name="agreements[{{ $index }}][customer_id]">
                                                    <option selected="" disabled="">Select Customer</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}"
                                                            {{ old('agreements.' . $index . '.customer_id') == $customer->id ? 'selected' : '' }}>
                                                            {{ $customer->name . ' - ' . $customer->phone }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agreements.' . $index . '.customer_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <!--End of Select Customer -->
                                        </div>
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="mb-3">
                                                <label for="product_id{{ $index }}" class="form-label">Select
                                                    Product</label>
                                                <select
                                                    class="js-example-basic-single @error('agreements.' . $index . '.product_id') is-invalid @enderror"
                                                    id="product_id{{ $index }}"
                                                    name="agreements[{{ $index }}][product_id]">
                                                    <option selected="" disabled="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            {{ old('agreements.' . $index . '.product_id') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agreements.' . $index . '.product_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-12">
                                            <div class="mb-3">
                                                <label for="down_payment{{ $index }}" class="form-label">Down
                                                    Payment <span class="text-secondary">(GH₵)</span></label>
                                                <input type="text"
                                                    class="form-control @error('agreements.' . $index . '.down_payment') is-invalid @enderror"
                                                    id="down_payment{{ $index }}"
                                                    name="agreements[{{ $index }}][down_payment]"
                                                    value="{{ old('agreements.' . $index . '.down_payment') }}"
                                                    placeholder="0.00">
                                                @error('agreements.' . $index . '.down_payment')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="mb-3">
                                                <label for="humanfrienndlydate{{ $index }}"
                                                    class="form-label">Date</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i>
                                                        </div>
                                                        <input type="text"
                                                            name="agreements[{{ $index }}][created_at]"
                                                            class="form-control @error('agreements.' . $index . '.created_at') is-invalid @enderror"
                                                            id="humanfrienndlydate{{ $index }}"
                                                            value="{{ old('agreements.' . $index . '.created_at') }}"
                                                            placeholder="Select Date">
                                                        @error('agreements.' . $index . '.created_at')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row py-2" id="agreementFormRow0">
                                    <div class="col-xxl-4 col-xl-12">
                                        <!--Select Customer -->
                                        <div class="mb-3">
                                            <label for="customer_id" class="form-label">Select Customer</label>
                                            <select
                                                class="js-example-basic-single @error('agreements.0.customer_id') is-invalid @enderror"
                                                id="customer_id" name="agreements[0][customer_id]">
                                                <option selected="" disabled="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">
                                                        {{ $customer->name . ' - ' . $customer->phone }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agreements.0.customer_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!--End of Select Customer -->
                                    </div>
                                    <div class="col-xxl-3 col-xl-12">
                                        <div class="mb-3">
                                            <label for="product_id" class="form-label">Select Product</label>
                                            <select
                                                class="js-example-basic-single @error('agreements.0.product_id') is-invalid @enderror"
                                                id="product_id" name="agreements[0][product_id]">
                                                <option selected="" disabled="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agreements.0.product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="down_payment" class="form-label">Down Payment <span
                                                    class="text-secondary">(GH₵)</span></label>
                                            <input type="text"
                                                class="form-control @error('agreements.0.down_payment') is-invalid @enderror"
                                                id="down_payment" name="agreements[0][down_payment]" placeholder="0.00">
                                            @error('agreements.0.down_payment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xxl-3 col-xl-12">
                                        <div class="mb-3">
                                            <label for="humanfrienndlydate" class="form-label">Date</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i
                                                            class="ri-calendar-line"></i>
                                                    </div>
                                                    <input type="text" name="agreements[0][created_at]"
                                                        class="form-control @error('agreements.0.created_at') is-invalid @enderror"
                                                        id="humanfrienndlydate" placeholder="Select Date" />
                                                    @error('agreements.0.created_at')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endif



                            <div class="card-footer">
                                <button type="button" class="btn btn-sm btn-danger">Close</button>
                                <button type="submit" class="btn btn-sm btn-success">Save Agreement</button>
                            </div>
                        </form>
                    </div>

                </div>




            </div>

        </div>
        <!--End::row-1 -->

    </div>


@endsection




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
            $('.js-example-basic-single').select2();
        });
    </script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/date&time_pickers.js') }}"></script>

  

    <script>

        // Function to initialize Flatpickr for all date fields
    function initializeFlatpickr() {
        $('[id^="humanfrienndlydate"]').each(function() {
            flatpickr(this, {
                dateFormat: "Y-m-d",
            });
        });
    }

    // Call the initialization function when the document is ready (on page load)
    $(document).ready(function() {
        initializeFlatpickr(); // Re-initialize Flatpickr for old form data
    });
    
        // let counter = 0;
        // let counter = {{ count(old('agreements', [])) }};
        // Initialize the counter based on existing agreement rows
        let counter = document.querySelectorAll('[id^="agreementFormRow"]').length;

        function addAgrrementRow() {
            counter++
            console.log(counter);

            // const formRow = document.getElementById('agreementFormRow0');
            const formRow = document.getElementById('agreementForm');
            const newRow = document.createElement('div');
            newRow.className = 'row';
            newRow.innerHTML = `
                               <div class="row py-2" id="agreementFormRow${counter}">
                                <div class="col-xxl-4 col-xl-12">
                                    <!--Select Customer -->
                                    <div class="mb-3">
                                        <label for="customer_id${counter}" class="form-label">Select Customer</label>
                                        <select
                                            class="js-example-basic-single @error('agreements.0.customer_id') is-invalid @enderror"
                                            id="customer_id${counter}" name="agreements[${counter}][customer_id]">
                                            <option selected="" disabled="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('agreements.0.customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ addslashes($customer->name . ' - ' . $customer->phone) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('agreements.${counter}.customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!--End of Select Customer -->
                                </div>

                                <div class="col-xxl-3 col-xl-12">
                                    <div class="mb-3">
                                        <label for="product_id${counter}" class="form-label">Select Product</label>
                                        <select
                                            class="js-example-basic-single @error('agreements.0.product_id') is-invalid @enderror"
                                            id="product_id${counter}" name="agreements[${counter}][product_id]">
                                            <option selected="" disabled="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ old('agreements.${counter}.product_id') == $product->id ? 'selected' : '' }}>
                                                    {{ addslashes($product->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('agreements.${counter}.product_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-xl-12">
                                    <div class="mb-3">
                                        <label for="down_payment${counter}" class="form-label">Down Payment <span
                                                class="text-secondary">(GH₵)</span></label>
                                        <input type="text"
                                            class="form-control @error('agreements.${counter}.down_payment') is-invalid @enderror"
                                            id="down_payment${counter}" name="agreements[0][down_payment]"
                                            value="{{ old('agreements[${counter}][down_payment]') }}" placeholder="0.00">
                                        @error('agreements.${counter}.down_payment')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-3 col-xl-12">
                                    <div class="mb-3">
                                        <label for="humanfrienndlydate${counter}" class="form-label">Date</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                                </div>
                                                <input type="text" name="agreements[${counter}][created_at]"
                                                    class="form-control @error('agreements.${counter}.created_at') is-invalid @enderror"
                                                    id="humanfrienndlydate${counter}" value="{{ old('agreements[${counter}][created_at]') }}"
                                                    placeholder="Select Date">
                                                @error('agreements.${counter}.created_at')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                          
           
                            `;
            formRow.appendChild(newRow);

            $('.js-example-basic-single').select2();

            // Re-initialize flatpickr for the newly added date fields
            flatpickr(`#humanfrienndlydate${counter}`, {
                dateFormat: "Y-m-d",
            });
        }
    </script>
@endpush
