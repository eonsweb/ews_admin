<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProductImport implements ToModel, WithValidation, WithHeadingRow
{
  
    public function model(array $row)
    {

        // Check if the category exists or create it
        $category = Category::firstOrCreate(['name' => $row['category']]);
        
        // Check if the product already exists
        if (!Product::where('name', $row['name'])->exists()) {
            // Create the product with category_id
            return new Product([
                'name' => $row['name'],
                'sale_price' => $row['price'], 
                'stock_price' => $row['stock_price'] ?? 0.00,// Assuming price is in the Excel
                'category_id' => $category->id, // Associate category
                // Add other product fields as necessary
            ]);
        }
    }

    // Validation rules for the Excel import
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric', // Example validation for price
        ];
    }
}
