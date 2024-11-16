<!-- Modal -->
<div class="modal fade" id="paymentEditModal-{{ $payment->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="paymentEditModalLabel-{{ $payment->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.payment.update', $payment->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentEditModalLabel">Edit Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $payment->id }}">
                    <div class="row py-2 " >

                        <!-- Date Returned Form with Validation Errors ----------------------------->
                        <div class="col-xxl-2 col-xl-12">
                            <div class="mb-3">
                                <label for="humanfrienndlydate"
                                    class="form-label">Date</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-text text-muted"> <i
                                                class="ri-calendar-line"></i>
                                        </div>
                                        <input type="text"
                                            name="created_at"
                                            class="form-control @error('created_at') is-invalid @enderror"
                                            id="humanfrienndlydate"
                                            value="{{$payment->created_at}}"
                                            placeholder="Select Date">
                                    </div>
                                    @error('created_at')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Customer Returned Form with Validation Errors ----------------------------->
                        <div class="col-xxl-3 col-xl-12">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Select
                                    Customer</label>
                                <input type="text" class="form-control" name="customer_id" value="{{$payment->customer->name .' - '.$payment->customer->phone}}" readonly>
                                <input type="hidden" name="customer_id" value="{{ $payment->customer_id }}">
                                @error('customer_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!--End of Select Customer -->

                        <!-- Product Returned Form with Validation Errors ----------------------------->
                        <div class="col-xxl-3 col-xl-12">
                            <div class="mb-3">
                                <label for="agreement_id" class="form-label">Select
                                    Transaction Agreement</label>
                                <select
                                    class="js-example-basic-single 
                                    @error('agreement_id') 
                                    is-invalid @enderror "
                                    id="agreement_id"
                                    name="agreement_id">
                                    <option selected="" disabled="">Section Transaction ID and Product
                                    </option>
                                    {{-- @foreach ($agreements as $agreement)
                                        <option value="{{ $agreement->id }}"
                                            {{ old('agreement_id') == $agreement->id ? 'selected' : '' }}>
                                            {{ $agreement->product->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                @error('agreement_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Amount Paid Returned Form with Validation Errors ----------------------------->
                        <div class="col-xxl-4 col-xl-12">
                            <div class="row">

                                <div class="col-xxl-5 col-xl-12">
                                    <div class="mb-3">
                                        <label for="amount_paid" class="form-label">Amt Paid<span class="text-secondary">(GH₵)</span></label>
                                        <input type="text"
                                            class="form-control @error('amount_paid') is-invalid @enderror"
                                            id="amount_paid"
                                            name="amount_paid"
                                            value="{{$payment->amount_paid}}"
                                            placeholder="Amount (GH₵)">
                                        @error('amount_paid')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-xxl-5 col-xl-12">
                                    <div class="mb-3">
                                        <label for="employee_id"
                                            class="form-label">Select
                                            Employee</label>
                                        <select
                                            class="js-example-basic-single @error('employee_id') is-invalid @enderror"
                                            id="employee_id"
                                            name="employee_id">
                                            <option selected="" disabled="">Select Employee</option>
                                            {{-- @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                               
                            </div>

                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Update Payment</button>
                </div>
            </form>
        </div>

    </div>
</div>
