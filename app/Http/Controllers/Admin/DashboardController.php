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
        $currentMonthSales = Agreement::currentMonthSales();
        $compareMonths = Agreement::compareMonthlySales();

        // dd($compareMonths );
        $currentMonthPayments = Payment::currentMonthPayments();


        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Top Selling Products
        $topProducts = Agreement::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(agreements.quantity * products.sale_price) as total_price')
                )
         ->join('products', 'agreements.product_id', '=', 'products.id')
        ->whereMonth('start_date', $currentMonth)
        ->whereYear('start_date', $currentYear)
        ->groupBy('product_id')
        ->having('total_quantity', '>', 0)
        ->orderBy('total_quantity', 'desc')
        ->get();


        // Top Selling Categories
    $topCategories = DB::table('agreements')
    ->join('products', 'agreements.product_id', '=', 'products.id')
    ->join('categories', 'products.category_id', '=', 'categories.id')
    ->select(
        'categories.id',
        'categories.name',
        DB::raw('SUM(agreements.quantity) as total_quantity_sold'),
        DB::raw('SUM(agreements.quantity * products.sale_price) as total_amount_sold')
    )
    ->whereMonth('start_date', $currentMonth)
    ->whereYear('start_date', $currentYear)
    ->groupBy('categories.id', 'categories.name')
    ->orderByDesc('total_quantity_sold')
    ->get();

        $month= Carbon::now()->month;
        return view('admin.dashboard',compact('currentMonthSales','currentMonthPayments','compareMonths','topProducts','topCategories'));


    }

    

   
}
