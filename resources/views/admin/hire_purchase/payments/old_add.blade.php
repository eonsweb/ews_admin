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
            <div id="paymentRows">

                <div class="card custom-card">
                    <form action="{{ route('admin.payment.store') }}" method="POST">
                        <div class="card-header d-sm-flex d-block">
                            <div class="card-title">
                                <div class="ms-auto">
                                    <button class="btn btn-secondary btn-sm" onclick="addAgrrementRow()"><i
                                            class="bx bx-plus"></i>Add New Row</button>
                                </div>
                            </div>

                        </div>

                        <div class="card-body" id="paymentForm">
                            {{-- <form id="paymentForm" action="{{ route('admin.payment.store') }}" method="POST"> --}}
                            @csrf

                            @if (old('payments'))

                                @foreach (old('payments') as $index => $oldPayment)
                                    <div class="row py-2 " id="paymentFormRow{{ $index }}">

                                        <!-- Date Returned Form with Validation Errors ----------------------------->
                                        <div class="col-xxl-2 col-xl-12">
                                            <div class="mb-3">
                                                <label for="humanfrienndlydate{{ $index }}"
                                                    class="form-label">Date</label>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-text text-muted"> <i
                                                                class="ri-calendar-line"></i>
                                                        </div>
                                                        <input type="text"
                                                            name="payments[{{ $index }}][created_at]"
                                                            class="form-control @error('payments.' . $index . '.created_at') is-invalid @enderror"
                                                            id="humanfrienndlydate{{ $index }}"
                                                            value="{{ old('payments.' . $index . '.created_at') }}"
                                                            placeholder="Select Date">
                                                    </div>
                                                    @error('payments.' . $index . '.created_at')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Customer Returned Form with Validation Errors ----------------------------->
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="mb-3">
                                                <label for="customer_id{{ $index }}" class="form-label">Select
                                                    Customer</label>
                                                <select
                                                    class="js-example-basic-single @error('payments.' . $index . '.customer_id') is-invalid @enderror"
                                                    id="customer_id{{ $index }}"
                                                    name="payments[{{ $index }}][customer_id]">
                                                    <option selected="" disabled="">Select Customer</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}"
                                                            {{ old('payments.' . $index . '.customer_id') == $customer->id ? 'selected' : '' }}>
                                                            {{ $customer->name . ' - ' . $customer->phone }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('payments.' . $index . '.customer_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!--End of Select Customer -->

                                        <!-- Product Returned Form with Validation Errors ----------------------------->
                                        <div class="col-xxl-3 col-xl-12">
                                            <div class="mb-3">
                                                <label for="agreement_id{{ $index }}" class="form-label">Select
                                                    Transaction Agreement</label>
                                                <select
                                                    class="js-example-basic-single 
                                                    @error('payments.' . $index . '.agreement_id') 
                                                    is-invalid @enderror "
                                                    id="agreement_id{{ $index }}"
                                                    name="payments[{{ $index }}][agreement_id]">
                                                    <option selected="" disabled="">Section Transaction ID and Product
                                                    </option>
                                                    @foreach ($agreements as $agreement)
                                                        <option value="{{ $agreement->id }}"
                                                            {{ old('payments.' . $index . '.agreement_id') == $agreement->id ? 'selected' : '' }}>
                                                            {{ $agreement->product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('payments.' . $index . '.agreement_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Amount Paid Returned Form with Validation Errors ----------------------------->
                                        <div class="col-xxl-4 col-xl-12">
                                            <div class="row">

                                                <div class="col-xxl-5 col-xl-12">
                                                    <div class="mb-3">
                                                        <label for="amount_paid{{ $index }}" class="form-label">Down
                                                            Payment <span class="text-secondary">(GH₵)</span></label>
                                                        <input type="text"
                                                            class="form-control @error('payments.' . $index . '.amount_paid') is-invalid @enderror"
                                                            id="amount_paid{{ $index }}"
                                                            name="payments[{{ $index }}][amount_paid]"
                                                            value="{{ old('payments.' . $index . '.amount_paid') }}"
                                                            placeholder="Amount (GH₵)">
                                                        @error('payments.' . $index . '.amount_paid')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xxl-5 col-xl-12">
                                                    <div class="mb-3">
                                                        <label for="product_id{{ $index }}"
                                                            class="form-label">Select
                                                            Employee</label>
                                                        <select
                                                            class="js-example-basic-single @error('payments.' . $index . '.employee_id') is-invalid @enderror"
                                                            id="employee_id{{ $index }}"
                                                            name="payments[{{ $index }}][employee_id]">
                                                            <option selected="" disabled="">Select Employee</option>
                                                            @foreach ($employees as $employee)
                                                                <option value="{{ $employee->id }}"
                                                                    {{ old('payments.' . $index . '.employee_id') == $employee->id ? 'selected' : '' }}>
                                                                    {{ $employee->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('payments.' . $index . '.employee_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xxl-2 col-xl-12">
                                                    <div class="col-xxl-1 col-xl-12">
                                                        <div class="centered mt-4 ms-3">
                                                            <button id="removepayment{{ $index }}"
                                                                class=" btn btn-sm btn-icon btn-danger-transparent rounded-pill btn-wave"
                                                                onclick="removeRow({{ $index }})">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <div class="row py-2 bg-light" id="paymentFormRow0">

                                      <!-- Date New ----------------------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="humanfrienndlydate" class="form-label">Date</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i
                                                            class="ri-calendar-line"></i>
                                                    </div>
                                                    <input type="text" name="payments[0][created_at]"
                                                        class="form-control @error('payments.0.created_at') is-invalid @enderror"
                                                        id="humanfrienndlydate" placeholder="Select Date" />
                                                </div>
                                                @error('payments.0.created_at')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!--Select Customer ------------------------->
                                    <div class="col-xxl-3 col-xl-12">

                                        <div class="mb-3">
                                            <label for="customer_id" class="form-label">Select Customer</label>
                                            <select id="customer_id"
                                                class="js-example-basic-single @error('payments.0.customer_id') is-invalid @enderror"
                                                name="payments[0][customer_id]">
                                                <option selected="" disabled="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">
                                                        {{ $customer->name . ' - ' . $customer->phone }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('payments.0.customer_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!--End of Select Customer -->
                                    </div>

                                    <!-- Agreement id ----------------------------->
                                    <div class="col-xxl-3 col-xl-12">
                                        <div class="mb-3">
                                            <label for="agreement_id" class="form-label">Select Transaction
                                                Agreement</label>
                                            <select
                                                class="js-example-basic-single @error('payments.0.agreement_id') is-invalid @enderror"
                                                id="agreement_id" name="payments[0][agreement_id]">
                                                <option selected="" disabled>-- Select Transaction ID and Product --
                                                </option>

                                            </select>
                                            @error('payments.0.agreement_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                      <!-- Amount Paid ----------------------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="amount_paid" class="form-label">Amout Paid <span
                                                    class="text-secondary">(GH₵)</span></label>
                                            <input type="text"
                                                class="form-control @error('payments.0.amount_paid') is-invalid @enderror"
                                                id="amount_paid" name="payments[0][amount_paid]" placeholder="Amount (GH₵)">
                                            @error('payments.0.amount_paid')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                      <!-- Agent ----------------------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="employee_id" class="form-label">Select Employee</label>
                                            <select
                                                class="js-example-basic-single @error('payments.0.employee_id') is-invalid @enderror"
                                                id="employee_id" name="payments[0][employee_id]">
                                                <option selected="" disabled="">Select Employee</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}">
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('payments.0.employee_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                            @endif


                        </div>

                        <div class="card-footer">
                            <div class="ms-auto">

                                {{-- 
                                <button type="button" class="btn btn-sm btn-danger">Close</button> --}}
                                <button type="submit" class="btn btn-sm btn-success">Save Payment</button>
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



        // Initialize the counter based on existing payment rows
        let counter = document.querySelectorAll('[id^="paymentFormRow"]').length;

        function addAgrrementRow() {
            event.preventDefault();
            counter++
            console.log(counter);


            // const formRow = document.getElementById('paymentFormRow0');
            const formRow = document.getElementById('paymentForm');
            const newRow = document.createElement('div');;
            newRow.innerHTML = `
                               <div class="row py-2 " id="paymentFormRow${counter}">

                                    <!-- Datee ----------------------->
                                    <div class="col-xxl-2 col-xl-12">
                                        <div class="mb-3">
                                            <label for="humanfrienndlydate${counter}" class="form-label">Date</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                                    </div>
                                                    <input type="text" name="payments[${counter}][created_at]"
                                                        class="form-control @error('payments.${counter}.created_at') is-invalid @enderror"
                                                        id="humanfrienndlydate${counter}" value="{{ old('payments[${counter}][created_at]') }}"
                                                        placeholder="Select Date">
                                                    @error('payments.${counter}.created_at')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Select Customer ------------>
                                    <div class="col-xxl-3 col-xl-12">
                                        <div class="mb-3">
                                            <label for="customer_id${counter}" class="form-label">Select Customer</label>
                                            <select
                                                class="js-example-basic-single @error('payments.0.customer_id') is-invalid @enderror"
                                                id="customer_id${counter}" name="payments[${counter}][customer_id]">
                                                <option selected="" disabled="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ old('payments.0.customer_id') == $customer->id ? 'selected' : '' }}>
                                                        {{ addslashes($customer->name . ' - ' . $customer->phone) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('payments.${counter}.customer_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!--End of Select Customer -->
                                    </div>

                                    <!-- Agreement Id -------------------->
                                    <div class="col-xxl-3 col-xl-12">
                                        <div class="mb-3">
                                            <label for="agreement_id${counter}" class="form-label">Select Transaction Agreement</label>
                                            <select
                                                id="agreement_id${counter}" name="payments[${counter}][agreement_id]"
                                                class="js-example-basic-single @error('payments.0.agreement_id') is-invalid @enderror"
                                               >
                                                <option selected="" disabled="">-- Section Transaction ID and Product --</option>
                                            </select>
                                            @error('payments.${counter}.agreement_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Amount Paid --------------------->
                                    <div class="col-xxl-4 col-xl-12">
                                        <div class="row">
                                                <div class="col-xxl-5 col-xl-12">
                                                    <div class="mb-3">
                                                        <label for="amount_paid${counter}" class="form-label">Amount Paid <span
                                                                class="text-secondary">(GH₵)</span></label>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control @error('payments.${counter}.amount_paid') is-invalid @enderror"
                                                                    id="amount_paid${counter}" name="payments[${counter}][amount_paid]"
                                                                    value="{{ old('payments[${counter}][amount_paid]') }}" placeholder="Amount (GH₵)"
                                                                >
                                                            </div>
                                                        </div>
                                                        @error('payments.${counter}.amount_paid')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xxl-5 col-xl-12">
                                                    <div class="mb-3">
                                                    <label for="employee_id${counter}" class="form-label">Select Employee</label>
                                                    <select
                                                        class="js-example-basic-single @error('payments.0.employee_id') is-invalid @enderror"
                                                        id="employee_id${counter}" name="payments[${counter}][employee_id]">
                                                        <option selected="" disabled="">Select Employee</option>
                                                        @foreach ($employees as $employee)
                                                            <option value="{{ $employee->id }}" {{ old('payments.${counter}.employee_id') == $employee->id ? 'selected' : '' }}>
                                                                {{ addslashes($employee->name) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('payments.${counter}.employee_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                </div>
                                                <div class="col-xxl-2 col-xl-12">
                                                    <div class="col-xxl-1 col-xl-12">
                                                        <div class="centered mt-4 ms-3">
                                                            <button id="removepayment${counter}" class=" btn btn-sm btn-icon btn-danger-transparent rounded-pill btn-wave" onclick="removeRow(${counter})">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                    
                                        
                            </div>                          
           
                            `;
            // Append the new row to the form
            formRow.appendChild(newRow);

            // Initialize Select2 for the newly created elements
            const dynamicCustomerId = `#customer_id${counter}`;
            const dynamicAgreementId = `#agreement_id${counter}`;

            // Initialize Select2 for the newly created elements
            $(dynamicCustomerId).select2();
            $(dynamicAgreementId).select2();
            // $(`#employee_id${counter}`).select2();

            // Set up event listener for customer selection
            setupCustomerAgreementEvent(dynamicCustomerId, dynamicAgreementId);

            $('.js-example-basic-single').select2();

            // Re-initialize flatpickr for the newly added date fields
            flatpickr(`#humanfrienndlydate${counter}`, {
                dateFormat: "Y-m-d",
            });

            updateRowBackgrounds();
        }

        // Function to remove a row
        function removeRow(counter) {
            const rowToRemove = document.getElementById(`paymentFormRow${counter}`);
            if (rowToRemove) {
                rowToRemove.remove(); // Remove the selected row
                updateRowBackgrounds(); // Call to update the row backgrounds after removing a row
                // Optionally decrement the counter if you want to maintain continuity
            }
        }

        function updateRowBackgrounds() {
            const rows = document.querySelectorAll('[id^="paymentFormRow"]');
            rows.forEach((row, index) => {
                if (index % 2 === 0) {
                    row.classList.add('bg-light'); // Light background for even rows
                } else {
                    row.classList.remove('bg-light'); // White background for odd rows
                }
            });
        }



        // Function to set up the event for dynamically created customers
        function setupCustomerAgreementEvent(dynamicCustomerId, dynamicAgreementId) {
            // Select customer_id when a customer is selected
            var customerSelect = $(dynamicCustomerId); // Use jQuery for select2 element
            var agreementSelect = document.querySelector(dynamicAgreementId);

            if (customerSelect.length > 0) {
                // Use select2's 'select2:select' event to capture when an option is selected
                customerSelect.on('select2:select', async function(event) {
                    // Get the selected customer_id
                    var selectedCustomerId = event.params.data.id;
                    console.log('Selected Customer ID:', selectedCustomerId);

                    if (selectedCustomerId) {
                        console.log('Customer ID selected:', selectedCustomerId);

                        agreementSelect.innerHTML = ''; // Clear existing options
                        agreementSelect.appendChild(new Option('-- Select Transaction ID and Product --',
                            '')); // Add a default option

                        const response = await fetchAgreements(selectedCustomerId);
                        const agreements = response.agreements; // Assuming agreements is returned as a property

                        console.log(agreements);

                        if (Array.isArray(agreements) && agreements.length > 0) {
                            agreements.forEach(agreement => {
                                // Create a new Option using the Option constructor
                                const option = new Option(
                                    `${agreement.transaction_id} - ${agreement.product_name}`, // Display text
                                    agreement.id // Value
                                );
                                agreementSelect.appendChild(option);
                            });
                        } else {
                            console.log('No agreements found for the selected customer.');
                            agreementSelect.innerHTML = '<option>No agreements available</option>';
                        }

                    } else {
                        console.log('No valid customer selected');
                    }
                });
            } else {
                console.log('Customer select element NOT found');
            }
        }

        async function fetchAgreements(customerId) {
            try {
                const response = await fetch('customer-transactions/' + customerId)
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                console.log(data);
                return data;
            } catch (error) {
                console.error('Error fetching Agreements:', error);
                alert('Error fetching Agreements');
                return [];
            }
        }

        // Call this function when the page is loaded to initialize for the default form
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 for the default form's customer and agreement dropdowns
            const defaultCustomerId = '#customer_id';
            const defaultAgreementId = '#agreement_id';

            $(defaultCustomerId).select2();
            $(defaultAgreementId).select2();

            // Call setup function for the default form
            setupCustomerAgreementEvent(defaultCustomerId, defaultAgreementId);
        });
    </script>
@endpush
