<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Imports\ProductImport;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Log;
use Exception;

class ProductController extends Controller
{
    public function AllProducts(){
        $products = Product::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.product.index',compact('products','categories'));
    }

    public function AddProduct()
    {
        return view('admin.product.add');
    }

    // Single Product Creation
    public function StoreProduct(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required|unique:products,name',
            'category_id' => 'required',
        ]);

        //Store the product
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->sale_price = $request->sale_price;
        $product->stock_price = $request->stock_price;
        $product->save();

        // Flash session to indicate the modal should stay open
        return redirect()->back()->with('modal', 'productNewModal');

        // Redirect back without showing the modal since it's a successful save
        // return redirect()->back()->with('success', 'Product saved successfully!');
    }

    // Import Product From excel or CVS
    public function ImportProducts(){
        return view('admin.product.import');
    }

    // Store Products Data Imported from Excel or Csv File
    public function StoreImportedProducts(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,cvs'
        ]);

        // dd('before importing');

        try {
            // Execute the Excel import
            Excel::import(new ProductImport, $request->file('file'));
    
            // Check if the import completes
            // dd('Import completed successfully');
        } catch (\Exception $e) {
            // Catch and display the error if it occurs
            dd('Error occurred: ' . $e->getMessage());
        }
        

        return redirect()->back()->with('success','Products imported successfully');
    }

    public function EditProduct($id)
    {
        $product = Product::find($id);
        return view('admin.product.edit', compact('product'));
    }

    public function UpdateProduct(Request $request)
    {
        // dd($request);
        $product = Product::find($request->id);

        $request->validate([
            // 'name' => 'required|unique:products,name,' . $product->id,
            'name' => 'required|unique:products,name,' . $product->id,
        ]);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->sale_price = $request->sale_price;
        $product->stock_price = $request->stock_price;
        $product->update();

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    public function DeleteProduct($id)
    {
        $product = Product::find($id);

        // Check if the product has any products
        // if ($product->products()->count() > 0) {
        //     return redirect()->back()->with('error', 'Product cannot be deleted because it has products.');
        // }

        // Delete the product
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }

}
