<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    public function AllCustomers(){
        $customers = Customer::latest()->get();
        return view('admin.customers.index',compact('customers'));
    }

    public function AddCustomer()
    {
        return view('admin.customers.add');
    }

    // Single Customer Creation
    public function StoreCustomer(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => ['required', 'unique:customers,phone', 'regex:/^[0-9]{10}$/'],
                'id_type' => 'nullable|string|max:20',
                'id_number' => 'nullable|string|max:20',
            ], [
                'phone.regex' => 'Phone number must be exactly 10 digits.',
            ]);
            
    
            //Store the customer
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->id_type = $request->id_type;
            $customer->id_number = $request->id_number;
            $customer->save();

            return redirect()->back()->with('success','Customer saved successfully');
        }catch(ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'customerNewModal');
        }catch (\Exception $e) {
            // Log exception and reopen modal
            return redirect()->back()->with('modal', 'customerNewModal');
        }
        // Validate inputs
        

        // Flash session to indicate the modal should stay open
        // return redirect()->back()->with('modal', 'customerNewModal');

        // Redirect back without showing the modal since it's a successful save
        // return redirect()->back()->with('success', 'Customer saved successfully!');
    }

    // Import Customer From excel or CVS
    public function ImportCustomers(){
        return view('admin.customers.import');
    }

    // Store Customers Data Imported from Excel or Csv File
    public function StoreImportedCustomers(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,cvs'
        ]);

        // dd('before importing');

        try {
            // Execute the Excel import
            Excel::import(new CustomerImport, $request->file('file'));
    
            // Check if the import completes
            // dd('Import completed successfully');
        } catch (\Exception $e) {
            // Catch and display the error if it occurs
            dd('Error occurred: ' . $e->getMessage());
        }
        

        return redirect()->back()->with('success','Customers imported successfully');
    }
    public function ShowCustomer($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.show.customer',compact('customer'));
    }

    public function EditCustomer($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function UpdateCustomer(Request $request)
    {
        $customer = Customer::find($request->id);

        $request->validate([
            // 'name' => 'required|unique:customers,name,' . $customer->id,
            'name' => 'required|unique:customers,name,' . $customer->id,
        ]);

        $customer->name = $request->name;
        $customer->slug = str_replace(' ','-',strtolower($customer->name));
        $customer->update();

        return redirect()->back('success', 'Customer updated successfully');
    }

    public function DeleteCustomer($id)
    {
        $customer = Customer::find($id);

        // Check if the customer has any customers
        // if ($customer->customers()->count() > 0) {
        //     return redirect()->back()->with('error', 'Customer cannot be deleted because it has customers.');
        // }

        // Delete the customer
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }

}
