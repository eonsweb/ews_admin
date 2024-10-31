<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Agreement extends Model
{
    use HasFactory;

    // public $timestamps = false;  // Disable timestamps if not needed

    // Listen to the creating event to generate a unique hire purchase ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agreement) {
            // Generate a unique hire purchase ID
            $agreement->transaction_id = self::generateUniqueHirePurchaseId();
        });
    }

    // Method to generate unique hire purchase ID
    public static function generateUniqueHirePurchaseId()
    {
        // Generate a random unique ID with a custom pattern
        $uniqueId = 'GR-' . strtoupper(Str::random(8)); // Example: GR-3A4C5D6F

        // Ensure that this ID is unique by checking if it exists in the database
        while (self::where('transaction_id', $uniqueId)->exists()) {
            $uniqueId = 'GR-' . strtoupper(Str::random(8)); // Ensure matching prefix
        }

        return $uniqueId;
    }

    // Inverse relationship (Many-to-One) with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    // One-to-many relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Inverse relationship (Many-to-One) with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function currentMonthSales()
    {
        return self::selectRaw(
            'COUNT(*) as number_of_agreements,
             SUM(principal) as total_sales,
             SUM((quantity * products.sale_price) - (quantity * products.stock_price)) as total_profit
             ',
        )
            ->whereYear('start_date', Carbon::now()->year)
            ->whereMonth('start_date', Carbon::now()->month)
            ->join('products', 'agreements.product_id', '=', 'products.id') // Join with products table
            ->first(); // Get the first result since we only need current month data
    }

    public static function compareMonthlySales()
{
    // Current Month Sales Data
    $currentMonth = self::selectRaw('
        COUNT(*) as current_month_number_of_sales,
        SUM(principal) as current_month_total_sales,
        SUM((quantity * products.sale_price) - (quantity * products.stock_price)) as current_month_profit
    ')
    ->whereYear('start_date', Carbon::now()->year)
    ->whereMonth('start_date', Carbon::now()->month)
    ->join('products', 'agreements.product_id', '=', 'products.id') // Join for current month
    ->first();

    // Previous Month Sales Data
    $previousMonth = self::selectRaw('
        COUNT(*) as previous_month_number_of_sales,
        SUM(principal) as previous_month_total_sales,
        SUM((quantity * products.sale_price) - (quantity * products.stock_price)) as previous_month_profit
    ')
    ->whereYear('start_date', Carbon::now()->year) // Corrected to start_date for consistency
    ->whereMonth('start_date', Carbon::now()->subMonth()->month)
    ->join('products', 'agreements.product_id', '=', 'products.id') // Join for previous month
    ->first();

    // Monthly Total Number of Sales
    $currentMonthNumberOfSales = $currentMonth->current_month_number_of_sales ?? 0;
    $previousMonthNumberOfSales = $previousMonth->previous_month_number_of_sales ?? 0;

    // Monthly Total Sales (Purchase)
    $currentMonthTotalSales = $currentMonth->current_month_total_sales ?? 0;
    $previousMonthTotalSales = $previousMonth->previous_month_total_sales ?? 0;

    // Monthly Total Profit
    $currentMonthProfit = $currentMonth->current_month_profit ?? 0;
    $previousMonthProfit = $previousMonth->previous_month_profit ?? 0;

    // Calculate Differences
    $differenceMonthlyNumberOfSales = $currentMonthNumberOfSales - $previousMonthNumberOfSales;
    $differenceInMonthlySales = $currentMonthTotalSales - $previousMonthTotalSales;
    $differenceInMonthlyProfit = $currentMonthProfit - $previousMonthProfit;

    // Calculate percentage changes
    $percentageMonthlyNumberOfSales = ($previousMonthNumberOfSales > 0)
        ? ($differenceMonthlyNumberOfSales / $previousMonthNumberOfSales) * 100
        : 0;

    $percentageInMonthlySales = ($previousMonthTotalSales > 0)
        ? ($differenceInMonthlySales / $previousMonthTotalSales) * 100
        : 0;

    $percentageInMonthlyProfit = ($previousMonthProfit > 0)
        ? ($differenceInMonthlyProfit / $previousMonthProfit) * 100
        : 0;

    $result = [
        'current_month_sales' => [
            'number_of_sales' => $currentMonthNumberOfSales,
            'total_sales' => $currentMonthTotalSales,
            'profit' => $currentMonthProfit,
        ],
        'previous_month_sales' => [
            'number_of_sales' => $previousMonthNumberOfSales,
            'total_sales' => $previousMonthTotalSales,
            'profit' => $previousMonthProfit,
        ],
        'sales_comparison' => [
            'number_of_sales' => [
                'absolute' => abs($differenceMonthlyNumberOfSales),
                'percentage' => $percentageMonthlyNumberOfSales,
                'status' => $differenceMonthlyNumberOfSales > 0 ? 'increase' : ($differenceMonthlyNumberOfSales < 0 ? 'decrease' : 'no change'),
            ],
            'total_sales' => [
                'absolute' => abs($differenceInMonthlySales),
                'percentage' => $percentageInMonthlySales,
                'status' => $differenceInMonthlySales > 0 ? 'increase' : ($differenceInMonthlySales < 0 ? 'decrease' : 'no change'),
            ],
            'profit' => [
                'absolute' => abs($differenceInMonthlyProfit),
                'percentage' => $percentageInMonthlyProfit,
                'status' => $differenceInMonthlyProfit > 0 ? 'increase' : ($differenceInMonthlyProfit < 0 ? 'decrease' : 'no change'),
            ],
        ],
    ];

    return $result; // Returns an associative array with all the results
}

    
}
