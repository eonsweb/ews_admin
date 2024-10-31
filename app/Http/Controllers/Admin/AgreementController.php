<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agreement;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Payment;

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

            // Calculate the Countdown for each agreement
            foreach ($agreements as $agreement) {
                $endDate = Carbon::parse($agreement->end_date);
                $differenceInDays = Carbon::now()->diffInDays($endDate, false);


                // Check if the agreement is completed
                if ($agreement->status == 'completed') {
                    $agreement->countDown = 'stop';
                } else {        
                    $agreement->countDown = is_numeric($differenceInDays) ? $differenceInDays : 0; // Default to 0 if not numeric
                }

                $total_amount_paid = Payment::where('agreement_id', $agreement->id)->sum('amount_paid');
                $agreement->balance = $agreement->principal - $total_amount_paid;
            }

            // dd($agreements);
            $customers = Customer::latest()->get();
            $products = Product::latest()->get();
            $employees = Employee::latest()->get();
            return view('admin.hire_purchase.agreements.index', compact('agreements', 'customers', 'products', 'employees'));
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
        $employees = Employee::latest()->get();
        return view('admin.hire_purchase.agreements.add', compact('customers', 'products', 'employees'));
    }

    // Multi Agreement Creation
    public function StoreAgreement(Request $request)
    {
        $request->validate(
            [
                'agreements.*.customer_id' => 'required|exists:customers,id',
                'agreements.*.product_id' => 'required|exists:products,id',
                'agreements.*.employee_id' => 'required|exists:employees,id',
                'agreements.*.down_payment' => 'required|numeric|min:0',
            ],
            [
                'agreements.*.customer_id.required' => 'Please select a customer.',
                'agreements.*.customer_id.exists' => 'The selected customer is invalid.',
                'agreements.*.product_id.required' => 'Please select a product.',
                'agreements.*.product_id.exists' => 'The selected product is invalid.',
                'agreements.*.employee_id.required' => 'Please select an employee.',
                'agreements.*.employee_id.exists' => 'The selected employee is invalid.',
                'agreements.*.down_payment.required' => 'A down payment is required.',
                'agreements.*.down_payment.numeric' => 'The down payment must be a number.',
                'agreements.*.down_payment.min' => 'The down payment must be at least 0.',
            ],
        );

        try {
            
            // dd($request);
            DB::transaction(function () use ($request) {
                $agreements = $request->agreements;

                // dd($agreements);

                foreach ($agreements as $ag) {
                    $product = Product::find($ag['product_id']);
                    if (!$product) {
                        return redirect()
                            ->back()
                            ->withErrors(['product' => 'Product not found'])
                            ->withInput();
                    }

                    $duration = (int) ($ag['duration'] ?? 3);
                    $startDate = Carbon::parse($ag['start_date'] ?? now());
                    $endDate = Carbon::parse($ag['start_date'])->addMonths($duration);

                    $quantity = (float) ($ag['quantity'] ?? 1);

                    $principal = $product->sale_price * $quantity;

                    $agreement = new Agreement();

                    $agreement->customer_id = $ag['customer_id'];
                    $agreement->product_id = $ag['product_id'];
                    $agreement->principal = $principal;
                    $agreement->quantity = $quantity;
                    $agreement->down_payment = $ag['down_payment'];
                    $agreement->total_paid = $ag['down_payment'];
                    $agreement->employee_id = $ag['employee_id'];

                    $agreement->start_date = $startDate;
                    $agreement->created_at = $startDate;
                    $agreement->updated_at = $startDate;
                    $agreement->duration = $duration;
                    $agreement->end_date = $endDate;

                    if ($agreement->principal <= $agreement->down_payment) {
                        $agreement->status = 'completed';
                    } else {
                        $agreement->status = 'active';
                    }

                    // Save Agreement
                    $agreement->save();

                    // Payment
                    $payment = new Payment();
                    $payment->customer_id = $agreement->customer_id;
                    $payment->agreement_id = $agreement->id;
                    $payment->employee_id = $agreement->employee_id;
                    $payment->amount_paid = $agreement->down_payment;
                    $payment->cumulative_total_paid = $agreement->down_payment;
                    $payment->created_at = $startDate;

                    $payment->save();
                }
            });

            return redirect()
                    ->route('admin.agreements')
                    ->with(['type'=>'success','message'=> 'Agreement saved successfully']);
        } catch (ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            Log::error('Agreement Store Error: ' . $e->getMessage());
            return redirect()
                ->back()
                // ->withErrors(['type'=>'error','message' => 'An error occurred while saving the agreements.'])
                ->with(['type'=>'error','message'=> $e->getMessage()])
                ->withInput();
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
        $request->validate(
            [
                'customer_id' => 'required|exists:customers,id',
                'product_id' => 'required|exists:products,id',
                'employee_id' => 'required|exists:employees,id',
                'down_payment' => 'required|numeric|min:0',
            ],
            [
                'customer_id.required' => 'Please select a customer.',
                'customer_id.exists' => 'The selected customer is invalid.',
                'product_id.required' => 'Please select a product.',
                'product_id.exists' => 'The selected product is invalid.',
                'employee_id.required' => 'Please select an employee.',
                'employee_id.exists' => 'The selected employee is invalid.',
                'down_payment.required' => 'A down payment is required.',
                'down_payment.numeric' => 'The down payment must be a number.',
                'down_payment.min' => 'The down payment must be at least 0.',
            ]
        );
        try {
            DB::transaction(function () use ($request) {

                $agreement = Agreement::findOrFail($request->id);
            $product = Product::findOrFail($request->product_id);
            // Locate and update the Payment record first based on agreement_id and possibly other criteria
            $initialPayment = Payment::where('agreement_id', $request->id)
                                        ->where('amount_paid',$agreement->down_payment)
                                        ->first();
            
        
            if ($initialPayment) {
                $initialPayment->customer_id = $request->customer_id;
                $initialPayment->employee_id = $request->employee_id;
                $initialPayment->amount_paid = $request->down_payment;
                $initialPayment->cumulative_total_paid = $request->down_payment;
                $initialPayment->created_at = Carbon::parse($request->start_date);
                $initialPayment->update();
            }
        
            // Now locate and update the Agreement record
            $agreement->customer_id = $request->customer_id;
            $agreement->product_id = $request->product_id;
            $agreement->employee_id = $request->employee_id;
            $agreement->down_payment = $request->down_payment;
            $agreement->total_paid = $request->down_payment;
            $agreement->quantity = $request->quantity;
            $agreement->principal = $request->quantity * $product->sale_price;
            $agreement->duration = $request->duration;
            $agreement->start_date = Carbon::parse($request->start_date);
            $agreement->created_at = Carbon::parse($request->start_date);
            $agreement->updated_at = now();
            $agreement->update();
            });

        
            return redirect()
                ->route('admin.agreements')
                ->with(['type' => 'success', 'message' => "Agreement Transaction  updated successfully"]);
        
        } catch (ValidationException $e) {
            dd('Validation failed', $e->errors());
        } catch (Exception $e) {
            dd('General exception', $e->getMessage());
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
