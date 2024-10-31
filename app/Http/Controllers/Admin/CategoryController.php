<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function AllCategories()
    {
        try {
            $categories = Category::latest()->get();

            foreach($categories as $category)
            {
                $category->date = Carbon::parse($category->created_at)->format('Y-m-d');
            }

            return view('admin.category.index', compact('categories'));
        } catch (Exception $e) {
            Log::error('Error fetching Categories: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()->back()->with(['type'=>'error', 'message'=> 'Failed to fetch Categories. Please try again later.']);
        }
    }

    public function AddCategory()
    {
        try {
            return view('admin.category.add');
        } catch (Exception $e) {
            Log::error('Error fetching for AddCategory: ' . $e->getMessage());
            Log::error($e);

            return redirect()->back()->with(['type'=>'error','message'=> 'Failed to fetch Add Category Page. Please try again later.']);
        }
    }

    // Single Category Creation
    public function StoreCategory(Request $request)
    {
        try {
            // Validate inputs
            $request->validate([
                'name' => 'required|unique:categories,name',
                'description' => 'nullable',
            ]);

            //Store the category
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            
            // Flash session to indicate the modal should stay open
            // return redirect()->back()->with('modal', 'categoryNewModal');
            return redirect()->back()->with(['type' =>'success','message'=> 'New category created successfully']);
            
        } 
        catch (ValidationException $e) 
        {
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'categoryNewModal');
        } 
        catch (Exception $e) {
            Log::error('Error Saving Category: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()->back()->with(['type'=>'error','message'=> 'Failed to Redirect to Import Categories Page. Please try again later.']);
        }
    }

    // Import Category From excel or CSv
    public function ImportCategories()
    {
        try {

            return view('admin.category.import');

        } catch (Exception $e) {
            Log::error('Error fetching Category import page: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()->back()->with(['type'=>'error','message' => 'Failed to Redirect to Import Category Page. Please try again later.']);
        }
    }

    // Store Categories Data Imported from Excel or Csv File
    public function StoreImportedCategories(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'file' => 'required|mimes:xlsx,csv', // Ensure the uploaded file is either xlsx or csv
            ]);
        
            // Import the categories from the uploaded file
            Excel::import(new CategoryImport, $request->file('file'));
    
            // Redirect back with a success message
            return redirect()->back()
                ->with([
                    'type'=>'success',
                    'message'=> 'Categories imported successfully!',
                ]);
        } 
        catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())->withInput()
                ->with(['type' => 'error', 
                        'message' => 'An error occurred while importing categories.<span class="fw-bolder"> Please read the Import Guide.</span>'
                ])
                ->with('modal', 'categoryImportModal');;
          

        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) 
        {
            // Handle validation errors specifically from the Excel import
            $failures = $e->failures(); // Get validation failures
            $errorMessages = [];
    
            foreach ($failures as $failure) {
                $errorMessages[] = $failure->errors(); // Extract the error messages
            }
    
            // Log the errors for debugging
            Log::error('Import errors: ' . json_encode($errorMessages));
    
            // Return back with errors
            return redirect()->back()->with(['type'=>'error','message'=> $errorMessages])->with('modal','categoryImportModal');
        } catch (\Exception $e) {
            // Log any other exceptions
            Log::error('Import error: ' . $e->getMessage());
    
            // Return a friendly error message
            return redirect()->back()
            ->with(['type'=>'error','message'=> 
                            'An error occurred while importing categories<span class="text-warning"> Please read the Import Guide.</span>'
                    ])
            ->with('modal','categoryImportModal');
        }
    }
    

    public function EditCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.category.edit', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with(['type'=>'error','message'=> 'Category not found.']);
        }catch (Exception $e) {
            Log::error('Error fetching for EditCategory Page: ' . $e->getMessage());
            Log::error($e);

            return redirect()->back()->with(['type'=>'error','message'=> 'Failed to fetch Add Category Page. Please try again later.']);
        }
        
    }

    public function UpdateCategory(Request $request)
{
    try {
        $category = Category::findOrFail($request->id);

        // Validate inputs
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
        ]);

        // Update category details
        $category->update($request->only('name', 'description'));

        return redirect()->back()->with(['type'=>'success','message'=> 'Category updated successfully']);
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput()->with(['modal'=> 'categoryEditModal', 'category_id' => $request->id]);
    } catch (ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Category not found.');
    } catch (Exception $e) {
        Log::error('Error updating category: ' . $e->getMessage());
        return redirect()->back()->with(['type'=>'error','message'=> 'Failed to update category. Please try again later.']);
    }
}

    public function DeleteCategory($id)
    {
        
        try{
            $category = Category::findOrFail($id);
            
            // Check if the category has any products
            if ($category->products()->count() > 0) {
                // dd('Category has products, cannot delete.');
                return redirect()->back()->with(['type'=>'error','message'=> 'Category cannot be deleted because it has products.']);
            }
    
            // Delete the category
            $category->delete();
            return redirect()->back()->with(['type'=>'success','message'=>'Category deleted successfully!']);
        }catch (ModelNotFoundException $e) {
            return redirect()->back()->with(['type'=>'error','message'=> 'Category not found.']);
        }catch(Exception $e){
            Log::error('Error fetching for EditCategory Page: ' . $e->getMessage());
            Log::error($e);

            return redirect()->back()->with(['type'=>'error','message' =>'Failed to Delete Category Page. Please try again later.']);
        }

    }
}
