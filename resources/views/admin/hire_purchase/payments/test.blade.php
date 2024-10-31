<div class="col-xxl-3 col-xl-12">
    <div class="mb-3">
        <label for="agreement_id" class="form-label">Select Transaction</label>
        <select
            class="js-example-basic-single @error('payments.0.agreement_id') is-invalid @enderror"
            id="agreement_id" name="">
            <option selected="" value="">Select Transaction</option>

        </select>
        @error('payments.0.agreement_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>




const agreementSelect = document.getElementById('agreement_id');
        const payment_form = document.getElementById('paymentForm');
       

        



        $('#customer_id').select2();

        // Select customer_id when a customer is selected
        var customerSelect = $('#customer_id'); // Use jQuery for select2 element

        if (customerSelect.length > 0) {
            // console.log('Customer select element found');

            // Use select2's 'select2:select' event to capture when an option is selected
            customerSelect.on('select2:select', async function(event) {
                // Get the selected customer_id
                var selectedCustomerId = event.params.data.id;
                console.log('Selected Customer ID:', selectedCustomerId);

                if (selectedCustomerId) {
                    console.log('Customer ID selected:', selectedCustomerId);

                    agreementSelect.innerHTML = ''; // Clear existing options
                    agreementSelect.appendChild(new Option('-- Section Transaction ID and Product --',
                    '')); // Add a default option

                    const response = await fetchAgreements(selectedCustomerId);
                    const agreements = await response.agreements;

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