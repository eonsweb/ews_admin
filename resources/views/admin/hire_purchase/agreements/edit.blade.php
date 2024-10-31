<!-- Modal -->
<div class="modal fade" id="agreementEditModal-{{ $agreement->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="agreementEditModalLabel-{{ $agreement->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.agreement.update', $agreement->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="agreementEditModalLabel">Edit Agreement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $agreement->id }}">
                    <div class="row">

                        {{-- Transaction ID: Unique, Disabled --}}
                        <div class="col-xxl-2 col-xl-12">
                            <div class="mb-3">
                                <label for="transaction_id" class="form-label">Transaction ID</label>
                                <input type="text" class="form-control @error('transacton_id') is-invalid @enderror"
                                    id="transaction_id" name="transaction_id" value="{{ $agreement->transaction_id }}"
                                    readonly />
                            </div>
                        </div>

                        {{-- Start Date --------------}}
                        <div class="col-xxl-3 col-xl-12">
                            <div class="mb-3">
                                <label for="humanfrienndlydate" class="form-label">Start Date</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-text text-muted"> <i
                                                class="ri-calendar-line"></i>
                                        </div>
                                        <input type="text" name="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            id="humanfrienndlydate" placeholder="Select Date" value="{{ $agreement->start_date }}" />
                                    </div>
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Customer ----------------}}
                        <div class="col-xxl-3 col-xl-12">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer Info</label>
                                <select class="js-example-basic-single" name="customer_id" id="customer_id">
                                    <option disabled>Select Agreement's Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ $customer->id == $agreement->customer_id ? 'selected' : '' }}>
                                            {{ $customer->name . ' - ' . $customer->phone }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Product --------------------}}
                        <div class="col-md-3 lg-4 xxl-3">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product Info</label>
                                <select class="js-example-basic-single" name="product_id" id="product_id">
                                    <option value="" disabled>Select Agreement's Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $product->id == $agreement->product_id ? 'selected' : '' }}>
                                            {{ $product->name . ' - ' . $product->sale_price }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Quantity --}}
                        <div class="col-xxl-2 col-xl-12">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-text">Qty</span>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                    id="quantity" step="0.1" min="0" name="quantity" value="{{ $agreement->quantity }}"
                                    />
                                </div>
                                @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                                
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div class="col-xxl-2 col-xl-12">
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration <span
                                        class="text-primary">(in Months)</span></label>
                                <div class="form-group">
                                    <select name="duration" id="duration"
                                        class="form-control form-select">
                                        <option selected disabled>Select Duration</option>
                                        <option value="3" {{ $agreement->duration == 3 ? 'selected' :''}}>3</option>
                                        <option value="4" {{ $agreement->duration == 4 ? 'selected' :''}}>4</option>
                                        <option value="5" {{ $agreement->duration == 5 ? 'selected' :''}}>5</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Down Payment --}}
                        <div class="col-xxl-2 col-xl-12">
                            <div class="mb-3">
                                <label for="down_payment" class="form-label">Down Payment</label>
                                <div class="input-group">
                                    <span class="input-group-text">GH₵</span>
                                    <input type="number" class="form-control @error('down_payment') is-invalid @enderror"
                                    id="down_payment" name="down_payment" value="{{ $agreement->down_payment }}"
                                    />
                                </div>
                                @error('down_payment')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                                
                            </div>
                        </div>

                        

                        {{-- Agent --------------------}}
                        <div class="col-md-3 lg-4 xxl-3">
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Agent Info</label>
                                <select class="js-example-basic-single" name="employee_id" id="employee_id">
                                    <option value="" disabled>Select Agent</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $employee->id == $agreement->employee_id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update Agreement</button>
                </div>
            </form>
        </div>

    </div>
</div>
