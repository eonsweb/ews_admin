<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agreement;
use App\Models\Customer;
use App\Models\Product;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Exception;
use Carbon\Carbon;

use Illuminate\Validation\ValidationException;

class AgreementController extends Controller
{
    public function AllAgreements()
    {
        try {
            $agreements = Agreement::latest()->get();
            $customers = Customer::latest()->get();
            $products = Product::latest()->get();
            return view('admin.hire_purchase.agreements.index', compact('agreements', 'customers', 'products'));
        } catch (Exception $e) {
            // Log the exception message
            Log::error('Error fetching agreements: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()->back()->with('error', 'Failed to fetch agreements. Please try again later.');
        }
    }

    public function AddAgreement()
    {
        $customers = Customer::latest()->get();
        $products = Product::latest()->get();
        return view('admin.hire_purchase.agreements.add', compact('customers', 'products'));
    }

    // Single Agreement Creation
    public function StoreAgreement(Request $request)
    {
        try {
            $request->validate(
                [
                    'agreements.*.customer_id' => 'required|exists:customers,id',
                    'agreements.*.product_id' => 'required|exists:products,id',
                    'agreements.*.down_payment' => 'required|numeric|min:0',
                    'agreements.*.created_at' => 'required|date',
                ],
                [
                    'agreements.*.customer_id.required' => 'Please select a customer for this agreement.',
                    'agreements.*.customer_id.exists' => 'The selected customer is invalid.',
                    'agreements.*.product_id.required' => 'Please select a product for this agreement.',
                    'agreements.*.product_id.exists' => 'The selected product is invalid.',
                    'agreements.*.down_payment.required' => 'A down payment is required.',
                    'agreements.*.down_payment.numeric' => 'The down payment must be a number.',
                    'agreements.*.down_payment.min' => 'The down payment must be at least 0.',
                    'agreements.*.created_at.required' => 'The date is required.',
                    'agreements.*.created_at.date' => 'Please enter a valid date.',
                ],
            );

            DB::transaction(function () use ($request) {
                $agreements = $request->input('agreements');

                foreach ($agreements as $ag) {
                    $product = Product::find($ag['product_id']);
                    if (!$product) {
                        return redirect()
                            ->back()
                            ->withErrors(['product' => 'Product not found'])
                            ->withInput();
                    }

                    $agreement = new Agreement();

                    $agreement->customer_id = $ag['customer_id'];
                    $agreement->product_id = $ag['product_id'];
                    $agreement->principal = $product->sale_price;
                    $agreement->down_payment = $ag['down_payment'];

                    $agreement->created_at = Carbon::parse($ag['created_at']);
                    $agreement->updated_at = Carbon::parse($ag['created_at']);
                    $agreement->status = 'active';

                    // Save Agreement
                    $agreement->save();
                }
            });

            return redirect()->route('admin.agreements')->with('success', 'Agreement saved successfully');
            
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log exception and reopen modal
            Log::error('Agreement Store Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred while saving the agreements.'])
                ->withinput();
        }
    }

    public function ShowAgreement($id)
    {
        $agreement = Agreement::find($id);
        return view('admin.agreements.show.agreement', compact('agreement'));
    }

    public function EditAgreement($id)
    {
        $agreement = Agreement::find($id);
        return view('admin.hire_purchase.agreements.edit', compact('agreement'));
    }

    public function UpdateAgreement(Request $request)
    {
        try {
            $agreement = Agreement::find($request->id);

            $request->validate([
                'name' => 'required|unique:agreements,name,' . $agreement->id,
                'product_id' => 'required',
                'customer_id' => 'required',
                'down_payment' => 'required',
                'total_amount' => 'required',
                'status' => 'required',
            ]);

            $agreement->name = $request->name;
            $agreement->customer_id = $request->customer_id;
            $agreement->product_id = $request->product_id;
            $agreement->total_amount = $request->total_amount;
            $agreement->down_payment = $request->down_payment;
            $agreement->status = $request->status;
            $agreement->update();

            return redirect()->back('success', 'Agreement updated successfully');
        } catch (ValidationException $e) {
        } catch (Exception $e) {
        }
    }

    public function DeleteAgreement($id)
    {
        $agreement = Agreement::find($id);

        // Check if the agreement has any agreements
        // if ($agreement->agreements()->count() > 0) {
        //     return redirect()->back()->with('error', 'Agreement cannot be deleted because it has agreements.');
        // }

        // Delete the agreement
        $agreement->delete();

        return redirect()->back()->with('success', 'Agreement deleted successfully!');
    }
}
