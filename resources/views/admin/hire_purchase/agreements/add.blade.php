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

    <style>
        .centered {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            /* Make sure this div takes full height of the column */
        }
    </style>
@endpush


@section('main-content')
    <div class="container-fluid">



        <!-- Start::row-1 -->
        <div class="row">
            <div id="agreementRows">

                <div class="card custom-card">
                    <form action="{{ route('admin.agreement.store') }}" method="POST">
                        <div class="card-header d-sm-flex d-block">
                            <div class="card-title">
                                <div class="ms-auto">
                                    <button class="btn btn-secondary btn-sm" type="button" onclick="addAgreementRow()"><i
                                            class="bx bx-plus"></i>Add New Row</button>
                                </div>

                            </div>
                            <div class="ms-auto">
                                <a class="btn btn-success btn-sm" href="{{ route('admin.agreements') }}"><i
                                        class="bx bx-arrow-back"></i>Back to Agreements</a>
                            </div>

                        </div>

                        <div class="card-body" id="agreementForm">
                            {{-- <form id="agreementForm" action="{{ route('admin.agreement.store') }}" method="POST"> --}}
                            @csrf

                            @if (old('agreements'))

                                @foreach (old('agreements') as $index => $oldAgreement)
                                    <div class="row py-2 " id="agreementFormRow{{ $index }}">

                                        <!-- Start Date -->
                                        <div class="col-xxl-2 col-xl-12">
                                            <div class="mb-3">
                                                <label for="humanfrienndlydate{{ $index }}" class="form-label">Start
                                                    Date</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i>
                                                        </div>
                                                        <input type="text"
                                                            name="agreements[{{ $index }}][start_date]"
                                                            class="form-control @error('agreements.' . $index . '.start_date') is-invalid @enderror"
                                                            id="humanfrienndlydate{{ $index }}"
                                                            value="{{ old('agreements.' . $index . '.start_date') }}"
                                                            placeholder="Select Date">
                                                    </div>
                                                    @error('agreements.' . $index . '.start_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Duraton  ---------------------->
                                        <div class="col-xxl-2 col-xl-12">
                                            <div class="mb-3">
                                                <label for="duration{{ $index }}" class="form-label">Duration <span
                                                        class="text-primary">(in Months)</span></label>
                                                <div class="form-group">
                                                    <select name="agreements[{{ $index }}][duration]"
                                                        id="duration{{ $index }}" class="form-control form-select">
                                                        <option disabled
                                                            {{ old('agreements.' . $index . '.duration') === null ? 'selected' : '' }}>
                                                            Select Duration</option>
                                                        <option value="3"
                                                            {{ old('agreements.' . $index . '.duration') == '3' ? 'selected' : '' }}>
                                                            3</option>
                                                        <option value="4"
                                                            {{ old('agreements.' . $index . '.duration') == '4' ? 'selected' : '' }}>
                                                            4</option>
                                                        <option value="5"
                                                            {{ old('agreements.' . $index . '.duration') == '5' ? 'selected' : '' }}>
                                                            5</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!--Select Customer ---------------->
                                        <div class="col-xxl-4 col-xl-12">
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

                                        <!--Select Product ---------------->
                                        <div class="col-xxl-4 col-xl-12">
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
                                                            {{ $product->name . ' - ' . $product->sale_price }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agreements.' . $index . '.product_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Down Payment ---------------------->
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

                                        <!-- Quantity --------------------------->
                                        <div class="col-xxl-2 col-xl-12">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Qty</span>
                                                <input type="number" name="agreements[{{ $index }}][quantity]"
                                                    placeholder="1"
                                                    value="{{ old('agreements.' . $index . '.quantity') }}"
                                                    class="form-control form-control-sm" min="0" step="any">
                                            </div>
                                            @error('agreements.' . $index . '.quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Employee ---------------------->
                                        <div class="col-xxl-2 col-xl-12">
                                            <div class="mb-3">
                                                <label for="product_id{{ $index }}" class="form-label">Select
                                                    Employee</label>
                                                <select
                                                    class="js-example-basic-single @error('agreements.' . $index . '.employee_id') is-invalid @enderror"
                                                    id="employee_id{{ $index }}"
                                                    name="agreements[{{ $index }}][employee_id]">
                                                    <option selected="" disabled="">Select Employee</option>
                                                    @foreach ($employees as $employee)
                                                        <option value="{{ $employee->id }}"
                                                            {{ old('agreements.' . $index . '.employee_id') == $employee->id ? 'selected' : '' }}>
                                                            {{ $employee->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('agreements.' . $index . '.employee_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Remove ---------------------->
                                        <div class="col-xxl-1 col-xl-12">
                                            <div class="col-xxl-1 col-xl-12">
                                                <div class="centered mt-4 ms-3">
                                                    <button id="removeagreement{{ $index }}"
                                                        class=" btn btn-sm btn-icon btn-danger-transparent rounded-pill btn-wave"
                                                        onclick="removeRow({{ $index }})">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <div class="row py-2 bg-light" id="agreementFormRow0">
                                    <!-- Start Date Form 0 -->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="humanfrienndlydate" class="form-label">Start Date</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i
                                                            class="ri-calendar-line"></i>
                                                    </div>
                                                    <input type="text" name="agreements[0][start_date]"
                                                        class="form-control @error('agreements.0.start_date') is-invalid @enderror"
                                                        id="humanfrienndlydate" placeholder="Select Date" />
                                                </div>
                                                @error('agreements.0.start_date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Duraton Form 0 -->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration <span
                                                    class="text-primary">(in Months)</span></label>
                                            <div class="form-group">
                                                <select name="agreements[0][duration]" id="duration"
                                                    class="form-control form-select">
                                                    <option selected disabled>Select Duration</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Customer Form 0 -->
                                    <div class="col-xxl-4 col-xl-12">
                                        <!--Select Customer -->
                                        <div class="mb-3">
                                            <label for="customer_id" class="form-label"></label>
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

                                    <!-- Product Form 0 -->
                                    <div class="col-xxl-4 col-xl-12">
                                        <div class="mb-3">
                                            <label for="product_id" class="form-label"></label>
                                            <select
                                                class="js-example-basic-single @error('agreements.0.product_id') is-invalid @enderror"
                                                id="product_id" name="agreements[0][product_id]">
                                                <option selected="" disabled="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">
                                                        {{ $product->name . ' - ' . $product->sale_price }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agreements.0.product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Quantity Form 0 -->
                                    <div class="col-xxl-2 col-xl-12">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Qty</span>
                                            <input type="number" name="agreements[0][quantity]"
                                                placeholder="1" class="form-control form-control-sm" min="0"
                                                step="any">
                                        </div>
                                        @error('agreements.0.quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Down Payment Form 0 -->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="down_payment" class="form-label">Down Payment</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text" id="inputGroup-sizing">GH₵</span>
                                                <input type="text"
                                                    class="form-control @error('agreements.0.down_payment') is-invalid @enderror"
                                                    id="down_payment" name="agreements[0][down_payment]"
                                                    placeholder="0.00">
                                            </div>
                                            @error('agreements.0.down_payment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Employee Form 0 -->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="employee_id" class="form-label"></label>
                                            <select
                                                class="form-control form-control-sm js-example-basic-single @error('agreements.0.employee_id') is-invalid @enderror"
                                                id="employee_id" name="agreements[0][employee_id]">
                                                <option selected="" disabled="">Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agreements.0.employee_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                            @endif





                        </div>

                        <div class="card-footer">
                            <div class="ms-auto text-end">

                                <button type="button" class="btn btn-sm btn-danger">Close</button>
                                <button type="submit" class="btn btn-sm btn-success">Save Agreement</button>
                            </div>
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
        // Initialize the counter based on existing agreement rows
        let counter = document.querySelectorAll('[id^="agreementFormRow"]').length;

        function addAgreementRow() {
            event.preventDefault();
            counter++
            console.log(counter);


            // const formRow = document.getElementById('agreementFormRow0');
            const formRow = document.getElementById('agreementForm');
            const newRow = document.createElement('div');
            // if (counter % 2 !== 0) {
            //     newRow.classList.add('bg-light');

            // }
            // newRow.classList.add('p-2');
            newRow.innerHTML = `
                               <div class="row pt-4 pb-2 " id="agreementFormRow${counter}">

                                    <!-- Start Date ------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="humanfrienndlydate${counter}" class="form-label">Start Date</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                                    </div>
                                                    <input type="text" name="agreements[${counter}][start_date]"
                                                        class="form-control @error('agreements.${counter}.start_date') is-invalid @enderror"
                                                        id="humanfrienndlydate${counter}" value="{{ old('agreements[${counter}][start_date]') }}"
                                                        placeholder="Select Date">
                                                    @error('agreements.${counter}.start_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Duraton Form  ---------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="duration${counter}" class="form-label">Duration <span class="text-primary">(in Months)</span></label>
                                            <div class="form-group">
                                                <select name="agreements[${counter}][duration]" id="duration${counter}" class="form-control form-select">
                                                    <option selected disabled>Select Duration</option>
                                                    <option value="3" >3</option>
                                                    <option value="4" >4</option>
                                                    <option value="5" >5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Customer ---------------->
                                    <div class="col-xxl-4 col-xl-12">
                                        <!--Select Customer -->
                                        <div class="mb-3">
                                            <label for="customer_id${counter}" class="form-label"></label>
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

                                    <!-- Product ---------------->
                                    <div class="col-xxl-4 col-xl-12">
                                        <div class="mb-3">
                                            <label for="product_id${counter}" class="form-label">Select Product</label>
                                            <select
                                                class="js-example-basic-single @error('agreements.0.product_id') is-invalid @enderror"
                                                id="product_id${counter}" name="agreements[${counter}][product_id]">
                                                <option selected="" disabled="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" {{ old('agreements.${counter}.product_id') == $product->id ? 'selected' : '' }}>
                                                        {{ addslashes($product->name) . ' - ' . $product->sale_price }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agreements.${counter}.product_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                     <!-- Quantity ---------------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <label for="quantity${counter}" class="form-label">Quantity</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Qty</span>
                                            <input type="number" name="agreements[${counter}][quantity]" id="quantity${counter}" placeholder="1" 
                                            class="form-control form-control-sm" min="0" step="any">
                                        </div>
                                        @error('agreements.${counter}.quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    
                                    <!-- Down Payment ------------------>
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="down_payment${counter}" class="form-label">Down Payment <span
                                                    class="text-secondary">(GH₵)</span></label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control @error('agreements.${counter}.down_payment') is-invalid @enderror"
                                                        id="down_payment${counter}" name="agreements[${counter}][down_payment]"
                                                        value="{{ old('agreements[${counter}][down_payment]') }}" placeholder="0.00"
                                                    >
                                                </div>
                                            </div>
                                            @error('agreements.${counter}.down_payment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                   

                                    <!-- Employee ------------------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="employee_id${counter}" class="form-label">Select Employee</label>
                                            <select
                                                class="js-example-basic-single @error('agreements.0.employee_id') is-invalid @enderror"
                                                id="employee_id${counter}" name="agreements[${counter}][employee_id]">
                                                <option selected="" disabled="">Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}" {{ old('agreements.${counter}.employee_id') == $employee->id ? 'selected' : '' }}>
                                                        {{ addslashes($employee->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('agreements.${counter}.employee_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Remove ------------------>
                                    <div class="col-xxl-1 col-xl-12">
                                        <div class="col-xxl-1 col-xl-12">
                                            <div class="centered mt-4 ms-3">
                                                <button id="removeagreement${counter}" class=" btn btn-sm btn-icon btn-danger-transparent rounded-pill btn-wave" onclick="removeRow(${counter})">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
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

            updateRowBackgrounds();
        }

        // Function to remove a row
        function removeRow(counter) {
            const rowToRemove = document.getElementById(`agreementFormRow${counter}`);
            if (rowToRemove) {
                rowToRemove.remove(); // Remove the selected row
                updateRowBackgrounds(); // Call to update the row backgrounds after removing a row
                // Optionally decrement the counter if you want to maintain continuity
            }
        }

        function updateRowBackgrounds() {
            const rows = document.querySelectorAll('[id^="agreementFormRow"]');
            rows.forEach((row, index) => {
                if (index % 2 === 0) {
                    row.classList.add('bg-light'); // Light background for even rows
                } else {
                    row.classList.remove('bg-light'); // White background for odd rows
                }
            });
        }
    </script>
@endpush
