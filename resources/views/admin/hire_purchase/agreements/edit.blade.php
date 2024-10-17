<div class="row py-2 ms-2 bg-light" id="agreementFormRow${counter}">
    <div class="col-xxl-4 col-xl-12">
        <!--Select Customer -->
        <div class="mb-3">
            <label for="customer_id${counter}" class="form-label">Select Customer</label>
            <select class="js-example-basic-single @error('customer_id$') is-invalid @enderror"
                id="customer_id${counter}" name="agreements[${counter}][customer_id]">
                <option selected="" disabled="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">
                        {{ addslashes($customer->name . ' - '  . $customer->phone) }}
                    </option>
                @endforeach
            </select>
            @error('agreements[${counter}][customer_id]')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <!--End of Select Customer -->
    </div>
    <div class="col-xxl-3 col-xl-12">
        <div class="mb-3">
            <label for="product_id${counter}${counter}" class="form-label">Select Product</label>
            <select class="js-example-basic-single @error('product_id') is-invalid @enderror"
                id="product_id${counter}" name="agreements[${counter}][product_id]">
                <option selected="" disabled="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ addslashes($product->name) }}
                    </option>
                @endforeach
            </select>
            @error('agreements[${counter}][product_id]')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-xxl-2 col-xl-12">
        <div class="mb-3">
            <label for="down_payment" class="form-label">Down Payment <span class="text-secondary">(GH₵)</span></label>
            <input type="text"
                class="form-control @error('down_payment') is-invalid @enderror"
                id="down_payment" name="agreements[${counter}][down_payment]" placeholder="0.00">
            @error('agreements[${counter}][down_payment]')
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
                    <input type="text" name="agreements[${counter}][created_at]" 
                    class="form-control @error('agreements[${counter}][created_at]') is-invalid @enderror" id="humanfrienndlydate${counter}"
                        placeholder="Select Date">
                    @error('agreements.${counter}.created_at')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

</div>
