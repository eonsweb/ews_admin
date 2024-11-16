<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function PaymentReport()
    {
        // Get total daily payments for each employee by name.
        $dailyPayments = DB::table('payments')->join('employees', 'payments.employee_id', '=', 'employees.id')->select(DB::raw('DATE(payments.created_at) as payment_date'), 'employees.id as employee_id', 'employees.name as employee_name', DB::raw('SUM(payments.amount_paid) as employee_daily_total'))->groupBy('payment_date', 'employees.id', 'employees.name')->orderBy('payment_date', 'DESC')->get();

        // dd($dailyPayments);

        return view('admin.report.index', compact('dailyPayments'));
        // return $dailyPayments;
    }

    public function generateMonthlyAgreementReport()
    {
        // Get the start and end dates from the request or set defaults
        

        $monthlyAgreements = DB::table('agreements')
            ->join('products', 'agreements.product_id', '=', 'products.id')
            ->select(DB::raw('DATE_FORMAT(start_date, "%Y-%m") as month'), 
                        DB::raw('COUNT(*) as total_agreements'), 
                        DB::raw('SUM(principal) as total_principal'), 
                        DB::raw('SUM(down_payment) as total_down_payment'), 
                        DB::raw('SUM(total_paid) as total_paid'),
                        DB::raw('SUM(agreements.principal - (products.stock_price * agreements.quantity)) as monthly_profit') // Monthly profit calculation
                        )
                        
            // ->whereBetween('start_date', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

            // dd( $monthlyAgreements);
        return view('admin.report.agreements.monthly_agreement_report', compact('monthlyAgreements'));
    }
}
