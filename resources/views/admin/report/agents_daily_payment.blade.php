
<div class="card custom-card" id="agents-daily-payments">
    <div class="card-header justify-content-between">
        <div class="card-title">
           Daily Payment Report for Employees
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="datatable-basic" class="table table-bordered text-nowrap table-striped w-100">
                <thead>
                    <tr>
                        <th style="width: 10%;">#</th>
                        <th>Date</th>
                        <th>Agent</th>
                        <th>Daily Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dailyPayments as $key => $payment)
                        @if ($payment->employee_id == 1)
                            <tr>
                                <td><span class="text-primary">{{$key+1}}</span></td>
                                <td><span class="text-primary">{{ $payment->payment_date}}</span></td>
                                <td><span class="text-primary">{{ $payment->employee_name }}</span></td>
                                <td><span class="text-primary">GH₵ {{ number_format($payment->employee_daily_total,2) }}</span></td>
                            </tr>
                        @elseif($payment->employee_id == 2)
                            <tr>
                                <td><span class="text-danger">{{$key+1}}</span></td>
                                <td><span class="text-danger">{{ $payment->payment_date}}</span></td>
                                <td><span class="text-danger">{{ $payment->employee_name }}</span></td>
                                <td><span class="text-danger">GH₵ {{ number_format($payment->employee_daily_total,2) }}</span></td>
                            </tr>
                        @elseif($payment->employee_id == 3)
                            <tr>
                                <td><span class="text-success">{{$key+1}}</span></td>
                                <td><span class="text-success">{{ $payment->payment_date}}</span></td>
                                <td><span class="text-success">{{ $payment->employee_name }}</span></td>
                                <td><span class="text-success">GH₵ {{ number_format($payment->employee_daily_total,2) }}</span></td>
                            </tr>
                        @else
                            <tr>
                                <td><span class="text-warning">{{$key+1}}</span></td>
                                <td><span class="text-warning">{{ $payment->payment_date}}</span></td>
                                <td><span class="text-warning">{{ $payment->employee_name }}</span></td>
                                <td><span class="text-warning">GH₵ {{ number_format($payment->employee_daily_total,2) }}</span></td>
                            </tr>
                    @endif
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>