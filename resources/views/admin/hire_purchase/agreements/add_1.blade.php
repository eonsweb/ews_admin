<!-- Modal -->
<div class="modal fade" id="agreementNewModal" data-bs-backdrop="static" tabindex="-1" data-bs-keyboard="false"
    aria-labelledby="agreementNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.agreement.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="agreementNewModalLabel">Add New Agreement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <button class="btn btn-success">Add row</button>

                    <div id="agreementRows">
                        <div class="row py-5">
                            <div class="col-xxl-4 col-xl-12">
                                <!--Select Customer -->
                                <div class="mb-3">
                                    <label for="customer" class="form-label">Customer</label>
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <select
                                            class="js-example-basic-single @error('customer_id') is-invalid @enderror"
                                            name="customer_id">
                                            <option selected="" disabled="">Select Customer</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->name ." - ". $customer->phone }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--End of Select Customer -->
                            </div>
                            <div class="col-xxl-3 col-xl-12">
                                <!--Select Product -->
                                <div class="mb-3">
                                    <label for="product" class="form-label">Product</label>
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <select
                                            class="js-example-basic-single @error('product_id') is-invalid @enderror"
                                            name="product_id">
                                            <option selected="" disabled="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!--End of Select Customer -->
                            </div>
                            <div class="col-xxl-2 col-xl-12">
                                <div class="mb-3">
                                    <label for="down_payment" class="form-label">Down Payment</label>
                                    <input type="text"
                                        class="form-control @error('down_payment') is-invalid @enderror"
                                        id="down_payment" name="down_payment">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-xxl-3 col-xl-12">
                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i>
                                            </div>
                                            <input type="text" class="form-control" id="humanfrienndlydate"
                                                placeholder="Select Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var addRowBtn = document.getElementById('addRowBtn');
                                var agreementRows = document.getElementById('agreementRows');

                                // Function to add a new row
                                addRowBtn.addEventListener('click', function() {
                                    // Find the first row to clone
                                    var firstRow = document.querySelector('.agreementRow');
                                    if (firstRow) {
                                        // Clone the first row
                                        var newRow = firstRow.cloneNode(true);

                                        // Reset input values in the cloned row
                                        var inputs = newRow.querySelectorAll('input');
                                        var selects = newRow.querySelectorAll('select');

                                        inputs.forEach(function(input) {
                                            input.value = ''; // Clear input values
                                        });

                                        selects.forEach(function(select) {
                                            select.selectedIndex = 0; // Reset the select dropdown to the first option
                                        });

                                        // Append the cloned row to the agreementRows container
                                        agreementRows.appendChild(newRow);
                                    }
                                });
                            });
                        </script>
                    @endpush








                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Save Agreement</button>
                </div>
            </form>
        </div>

    </div>
</div>
