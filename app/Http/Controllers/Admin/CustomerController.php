<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Imports\CustomerImport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function AllCustomers()
    {
        $customers = Customer::latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function AddCustomer()
    {
        return view('admin.customers.add');
    }

    // Single Customer Creation
    public function StoreCustomer(Request $request)
    {
        try {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'phone' => [
                        'required',
                        'unique:customers,phone', // Ensure the phone number is unique in the customers table
                        'regex:/^[0-9]{10}$/', // Ensure the phone number consists of exactly 10 digits
                    ],
                    'address' => 'required',
                    'id_type' => 'nullable|string|max:20',
                    'id_number' => 'nullable|string|max:20',
                ],
                [
                    'phone.regex' => 'Phone number must be exactly 10 digits.',
                ],
            );

            //Store the customer
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->id_type = $request->id_type;
            $customer->id_number = $request->id_number;
            $customer->save();

            return redirect()->back()->with('success', 'Customer saved successfully');
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'customerNewModal');
        } catch (\Exception $e) {
            // Log exception and reopen modal
            return redirect()->back()->with('modal', 'customerNewModal');
        }
        // Validate inputs
    }

    // Import Customer From excel or CVS
    public function ImportCustomers()
    {
        return view('admin.customers.import');
    }

    // Store Customers Data Imported from Excel or Csv File
    public function StoreImportedCustomers(Request $request)
    {
        $importCustomers = new CustomerImport();
        try {
            
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv',
            ]);

            // Execute the Excel import
            Excel::import($importCustomers, $request->file('file'));

            $errors = $importCustomers->getErrors();

            // Redirect back with a success message
            return redirect()
                ->back()
                ->with([
                    'type' => count($errors) > 0 ? 'error' : 'success',
                    'message' => count($errors) > 0 ? 'Products failed to import.' : 'Products imported successfully!',
                    'importErrors' => $errors, 
                ]);
        } 
        catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with([
                    'type' => 'error', 
                    'message' => 'An error occurred while importing Customers.<span class="fw-bolder"> Please read the Import Guide.</span>',
                    ])
                 ->with('modal','customerImportModal');
        } 
       
        catch (\Exception $e) {
            return redirect()
            ->back()
            ->with([
                'type' => 'error',
                'message' => 'An error occurred while importing Customers.',
            ]);
        }
    }
    public function ShowCustomer($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.show.customer', compact('customer'));
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
            'name' => 'required',
            'phone' => [
                'required',
                'unique:customers,phone,' . $customer->id, // Exclude current customer ID from the uniqueness check
                'regex:/^[0-9]{10}$/', // Ensure the phone number is exactly 10 digits
            ],

            'address' => 'required',
        ]);

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->id_type = $request->id_type;
        $customer->id_number = $request->id_number;

        // dd('customer');

        $customer->update();

        return redirect()
            ->back()
            ->with(['success', 'Customer updated successfully']);
    }

    public function DeleteCustomer($id)
    {
        $customer = Customer::find($id);

        // Check if the customer has any active agreement
        if ($customer->agreement()->count() > 0) {
            return redirect()->back()->with('error', 'Customer cannot be deleted because it has customers.');
        }

        // Delete the customer
        $customer->delete();

        return redirect()->back()->with('success', 'Customer deleted successfully!');
    }
}
