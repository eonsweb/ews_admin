<?php


namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;


class ProductImport implements ToModel,WithHeadingRow
{
    protected $errors = [];
    public function model(array $row)
    {
        // dd('Inside ProductImport');
        $row = array_change_key_case($row, CASE_LOWER);
        try{
            // Check if the category exists or create it
        $category = Category::firstOrCreate(['name' => $row['category']]);

        $stockPrice = isset($row['stock_price']) && is_numeric($row['stock_price']) ? $row['stock_price'] : null;
        $salePrice = isset($row['sale_price']) && is_numeric($row['sale_price']) ? $row['sale_price'] : null;
        $description = isset($row['description']) ? (string) $row['description'] : '';

        if ($stockPrice === null || $salePrice === null) {
            throw new \Exception("Invalid price format in row for product '{$row['name']}'");
        }
    

        $product = Product::updateOrCreate(
            ['name' => $row['name']], // Attributes to check for existing record
            [
                'description' => $description,
                'stock_price' => $stockPrice,
                'sale_price' => $salePrice,
                'category_id' => $category->id,
            ]
        );

        }catch (\Exception $e) {
            // $this->errors[] = 'Error with product: ' . json_encode($row) . ' - ' . $e->getMessage();
            $this->errors[0] = "Error with product '{$row['name']}': " . $e->getMessage();
          

        }

        
        
        // Check if the product already exists
        // if (!Product::where('name', $row['name'])->exists()) {
        //     // Create the product with category_id

        //     $product = new Product();
        //     $product->name = $row['name'];
        //     $product->description = isset($row['description']) ? (string) $row['description'] : '';
        //     $product->stock_price = isset($row['stock_price']) ? $row['stock_price'] : 0.00;
        //     $product->sale_price = isset($row['sale_price']) ? $row['sale_price'] : 0.00;
        //     $product->category_id = $category->id;

        //     // dd($product);
        //     $product->save();

        // }
    }

      // Method to retrieve errors after import
      public function getErrors()
      {
          return $this->errors;
      }
  

    // Validation rules for the Excel import
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category' => 'required',
            'stock_price' => 'nullable|numeric',
            'sale_price' => 'nullable|numeric',
        ];
    }
}
