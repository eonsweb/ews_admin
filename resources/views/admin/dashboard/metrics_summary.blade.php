<form method="GET" action="{{ route('dashboard.filter') }}" class="mb-4">
    <div class="row">
        <div class="col-md-10">
            <label for="date_range" class="h6">Filter by Date Range:</label>
            <select name="date_range" id="date_range" class="form-select">
                <option value="daily" {{ request('date_range') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="weekly" {{ request('date_range') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="monthly" {{ request('date_range') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ request('date_range') == 'yearly' ? 'selected' : '' }}>Yearly</option>
            </select>
        </div>
        <div class="col-md-2 d-flex justify-content-center align-items-end">
            <button type="submit" class="btn btn-primary mt-2 w-100">Apply</button>
        </div>
    </div>
    
</form>

<div class="row">
    <div class="col-md-6">
        <div class="card custom-card text-center">
            <div class="card-header">Total Active Agreements</div>
            <div class="card-body">{{ $metrics['totalActiveAgreements'] }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card custom-card text-center">
            <div class="card-header">Total Revenue</div>
            <div class="card-body">{{ number_format($metrics['totalRevenue'], 2) }} GHS</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card custom-card text-center">
            <div class="card-header">Outstanding Balances</div>
            <div class="card-body">{{ number_format($metrics['outstandingBalances'], 2) }} GHS</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card custom-card text-center">
            <div class="card-header">Total Payments Collected</div>
            <div class="card-body">{{ number_format($metrics['totalPaymentsCollected'], 2) }} GHS</div>
        </div>
    </div>
</div>