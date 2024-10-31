<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Imports\ProductImport;

use App\Models\Category;

use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function AllProducts()
    {
        try {
            $products = Product::latest()->get();
            $categories = Category::latest()->get();
            return view('admin.product.index', compact('products', 'categories'));
        } catch (Exception $e) {
            Log::error('Error fetching Products: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()
                ->back()
                ->with(['type' => 'error', 'message' => 'Failed to fetch Products. Please try again later.']);
        }
    }

    public function AddProduct()
    {
        try {
            return view('admin.product.add');
        } catch (Exception $e) {
            Log::error('Error fetching for AddProduct: ' . $e->getMessage());
            Log::error($e);

            return redirect()
                ->back()
                ->with(['type' => 'error', 'message' => 'Failed to fetch Add Product Page. Please try again later.']);
        }
    }

    // Single Product Creation
    public function StoreProduct(Request $request)
    {
        try {
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

            return redirect()
                ->back()->with(['type' => 'success', 'message' => 'Product saved successfully!']);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'productNewModal');
        } catch (Exception $e) {
            Log::error('Error Saving Category: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()
                ->back()
                ->with([
                    'type' => 'error',
                    'message' => 'Failed to Redirect to Import Products Page. Please try again later.',
                ]);
        }
    }

    // Import Product From excel or CVS
    public function ImportProducts(){
        try {
            return view('admin.product.import');
        } 
        catch (Exception $e) {
            Log::error('Error fetching Product import page: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()
                ->back()
                ->with([
                    'type' => 'error',
                    'message' => 'Failed to Redirect to Import Category Page. Please try again later.',
                ]);
        }
    }

    // Store Products Data Imported from Excel or Csv File
    public function StoreImportedProducts(Request $request)
    {
       $import = new ProductImport();
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            
            // Execute the Excel import
             Excel::import($import, $request->file('file'));

            // Check if there were any errors in the import
            $errors = $import->getErrors();

            // Redirect back with a success message
            return redirect()
                ->back()
                ->with([
                    'type' => count($errors) > 0 ? 'error' : 'success',
                    'message' => count($errors) > 0 ? 'Products failed to import.' : 'Products imported successfully!',
                    'importErrors' => $errors, // Pass to Blade view
                ]);
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with(['type' => 'error', 'message' => 'An error occurred while importing Products.<span class="fw-bolder"> Please read the Import Guide.</span>'])
                ->with('modal', 'productImportModal');
        } 
        catch (\Exception $e) {
            return redirect()
                ->back()
                ->with([
                    'type' => 'error',
                    'message' => 'An error occurred while importing Products.',
                ]);
        }
    }

    public function EditProduct($id)
    {
        try {
            $product = Product::find($id);
            return view('admin.product.edit', compact('product'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with(['type' => 'error', 'message' => 'Product not found.']);
        } catch (Exception $e) {
            Log::error('Error fetching for EditProduct Page: ' . $e->getMessage());
            Log::error($e);
            return redirect()
                ->back()
                ->with([
                    'type' => 'error',
                    'message' => 'Failed to fetch Add Product Page. Please try again later.',
                ]);
        }
    }

    public function UpdateProduct(Request $request)
    {
        try {
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

            return redirect()
                ->back()
                ->with([
                    'type' => 'success',
                    'message' => 'Product updated successfully',
                ]);
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with([
                    'modal' => 'productEditModal',
                    'product_id' => $request->id,
                ]);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with([
                    'type' => 'error',
                    'message' => 'Product not found.',
                ]);
        } catch (Exception $e) {
            Log::error('Error updating producct: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'type' => 'error',
                    'message' => 'Failed to update product. Please try again later.',
                ]);
        }
    }

    public function DeleteProduct($id)
    {
        try {
            $product = Product::find($id);
            // Delete the product
            $product->delete();

            return redirect()->back()->with('success', 'Product deleted successfully!');
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->with(['type' => 'error', 'message' => 'Product not found.']);
        } catch (Exception $e) {
            Log::error('Error fetching for EditProduct Page: ' . $e->getMessage());
            Log::error($e);

            return redirect()
                ->back()
                ->with(['type' => 'error', 'message' => 'Failed to Delete Product Page. Please try again later.']);
        }
    }
}
