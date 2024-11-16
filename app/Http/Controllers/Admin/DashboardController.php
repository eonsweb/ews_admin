<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agreement;
use App\Models\Payment;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function AdminDashboard()
    {
        // Set default date range (e.g., current month)
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Call the metrics calculation function
        $metrics = $this->calculateMetrics($startDate, $endDate);

        $currentMonthSales = Agreement::currentMonthSales();
        $previousMonthSales = Agreement::previousMonthSales();

        $compareMonths = Agreement::compareMonthlySales();

        // dd($compareMonths );
        $currentMonthPayments = Payment::currentMonthPayments();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Top Selling Products
        $topProducts = Agreement::select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(agreements.quantity * products.sale_price) as total_price'))
            ->join('products', 'agreements.product_id', '=', 'products.id')
            // ->whereMonth('start_date', $currentMonth)
            // ->whereYear('start_date', $currentYear)
            ->groupBy('product_id')
            ->having('total_quantity', '>', 0)
            ->orderBy('total_quantity', 'desc')
            ->get();

        // Top Selling Categories
        $topCategories = DB::table('agreements')
            ->join('products', 'agreements.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.id', 'categories.name', DB::raw('SUM(agreements.quantity) as total_quantity_sold'), DB::raw('SUM(agreements.quantity * products.sale_price) as total_amount_sold'))
            // ->whereMonth('start_date', $currentMonth)
            // ->whereYear('start_date', $currentYear)
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_quantity_sold')
            ->get();

        $month = Carbon::now()->month;

        $nearCompletionAgreements = $this->getNearingCompletionAgreements();
        
        return view('admin.dashboard', 
            compact(
                'currentMonthSales', 
                'previousMonthSales', 
                'currentMonthPayments', 
                'compareMonths', 
                'topProducts', 
                'topCategories',
                'metrics',
            'nearCompletionAgreements'));
    }

    public function Filter(Request $request)
    {
        $dateRange = $request->input('date_range');

        switch ($dateRange) {
            case 'daily':
                $startDate = Carbon::now();
                $endDate = Carbon::now();
                break;

            case 'weekly':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;

            case 'monthly':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
            case 'yearly':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
        }

       $metrics = $this->calculateMetrics($startDate,$endDate);
        return view('admin.dashboard',compact('metrics'));
    }

    private function calculateMetrics($startDate, $endDate)
    {
        // Total Active Agreements
        $totalActiveAgreements = Agreement::where('principal','!=', 'total_paid')->count();
        $completedAgreements = Agreement::where('principal','=', 'total_paid')->count();

        // Total Revenue (all-time revenue collected)
        $totalRevenue = Payment::sum('amount_paid');

        // Outstanding Balances (principal - total payments for each active agreement)
        $outstandingBalances = Agreement::where('status', 'active')
            ->sum(DB::raw('principal - (SELECT SUM(amount_paid) FROM payments WHERE payments.agreement_id = agreements.id)'));

        // Total Payments Collected within the date range
        $totalPaymentsCollected = Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount_paid');

        return [
            'totalActiveAgreements' => $totalActiveAgreements,
            'completedAgreements'   =>  $completedAgreements,
            'totalRevenue' => $totalRevenue,
            'outstandingBalances' => $outstandingBalances,
            'totalPaymentsCollected' => $totalPaymentsCollected,
        ];
    }

    private function getNearingCompletionAgreements()
    {
        $agreements = Agreement::where('status','active')
                        ->whereRaw('total_paid > principal / 2')
                        ->with('customer')
                        ->get();

        foreach ($agreements as $agreement) {
            $endDate = Carbon::parse($agreement->end_date);
            $differenceInDays = Carbon::now()->diffInDays($endDate, false);
            $agreement->countDown = is_numeric($differenceInDays) ? $differenceInDays : 0; // Default to 0 if not numeric
        }
            
        return $agreements;
    }
}
