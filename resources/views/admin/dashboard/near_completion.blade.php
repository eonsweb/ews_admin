<div class="col-xl-12">
    <div class="card custom-card">
        <div class="card-header">
            <div class="card-title h3">
                Customers Approaching Completion of Agreements
            </div>
        </div>
        <div class="card-body">
            <table id="responsivemodal-DataTable" class="table table-bordered text-nowrap w-100">
                <thead>
                    <tr>
                        <th>Customer Info</th>
                        <th>Agreement ID</th>
                        <th>Product</th>
                        <th>Principal</th>
                        <th>Total Paid</th>
                        <th>Time Left</th>
                        <th>Employee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nearCompletionAgreements as $agreement)
                        <tr>
                            <td>
                               
                                <span class="h6">{{ $agreement->customer->name}}</span>
                                <span class=" badge bg-primary-transparent">{{ $agreement->customer->phone }}</span>
                               
                            </td>
                            <td>{{ $agreement->transaction_id }}</td>
                            <td><span class="h6 text-primary">{{ $agreement->product->name }}</span></td>
                            <td class="text-danger">GH₵ {{ number_format($agreement->principal,2) }}</td>
                            <td class="text-success">GH₵ {{ number_format($agreement->total_paid,2) }}</td>
                            <td><span class="badge rounded-pill bg-warning">
                                {{ number_format($agreement->countDown, 0) . ' days' }}    
                            </span></td>
                            <td>{{ $agreement->employee->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
