<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Agreement;
use App\Models\Product;
use App\Models\Employee;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\ValidationException;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function AllPayments()
    {
        try {
            // $payments = Payment::latest()->get();
            // $customers = Customer::latest()->get();
            // $agreements = Agreement::latest()->get();
            // $employees = Employee::latest()->get();

            // return view('admin.hire_purchase.payments.index', compact('payments', 'customers', 'agreements', 'employees'));
            $payments = Payment::with(['customer', 'agreement', 'employee'])->latest()->get();
            // dd($payments);
            return view('admin.hire_purchase.payments.index', compact('payments'));
        
        } catch (Exception $e) {
            Log::error('Error fetching payments: ' . $e->getMessage());
            Log::error($e);

            // Return a friendly error message or redirect to an error page
            return redirect()->back()->with('error', 'Failed to fetch payments. Please try again later.');
        }
    }

    public function AddPayment()
    {
        $customers = Customer::latest()->get();
        $agreements = Agreement::latest()->get();
        $employees = Employee::latest()->get();
        $products = Product::latest()->get();

        return view('admin.hire_purchase.payments.add', compact('customers', 'products', 'employees', 'agreements'));
    }

    public function GetAgreements($customerId)
    {
        // Fetch agreements based on customer ID
        // $agreements = Agreement::where('customer_id', $customerId)
        //                         // ->whereColumn('principal','!=','total_paid')->get();
        //                         ->whereColumn('principal','>','total_paid')->get();

        $agreements = Agreement::where('customer_id', $customerId)
            ->where(function ($query) {
                $query->whereColumn('principal', '>', 'total_paid')->orWhere('principal', '=', 0);
            })
            ->get();

        // Return a response
        return response()->json([
            'agreements' => $agreements->map(function ($agreement) {
                return [
                    'id' => $agreement->id,
                    'transaction_id' => $agreement->transaction_id,
                    'product_name' => $agreement->product->name,
                    'product_price' => $agreement->product->sale_price,
                    'down_payment' => $agreement->down_payment,
                    'employee_id' => $agreement->employee_id,
                ];
            }),
        ]);
    }

    // Add Multiple Payments at Once
    public function StorePayment(Request $request)
    {
        $request->validate(
            [
                'payments.*.customer_id' => 'required|exists:customers,id',
                'payments.*.agreement_id' => 'required|exists:agreements,id',
                'payments.*.employee_id' => 'required|exists:employees,id',
                'payments.*.amount_paid' => 'required|numeric|min:0',
                'payments.*.created_at' => 'required|date',
            ],
            [
                'payments.*.customer_id.required' => 'Please select a customer.',
                'payments.*.customer_id.exists' => 'The selected customer is invalid.',
                'payments.*.agreement_id.required' => 'Please select an agreement.',
                'payments.*.agreement_id.exists' => 'The selected agreement is invalid.',
                'payments.*.employee_id.required' => 'Please select an employee.',
                'payments.*.employee_id.exists' => 'The selected employee is invalid.',
                'payments.*.amount_paid.required' => 'A amount paid is required.',
                'payments.*.amount_paid.numeric' => 'The amount paid must be a number.',
                'payments.*.amount_paid.min' => 'The amount paid must be at least 0.',
                'payments.*.created_at.required' => 'The date is required.',
                'payments.*.created_at.date' => 'Please enter a valid date.',
            ],
        );

        try {
            DB::transaction(function () use ($request) {
                // $payments = $request->input('payments');
                $payments = $request->payments;

                // dd($payments);

                foreach ($payments as $pay) {
                    // Payment
                    $agreement = Agreement::find($pay['agreement_id']);

                    // calculate new cumulative total paid
                    $agreement->total_paid = $agreement->total_paid + $pay['amount_paid'];
                    // dd($agreement->total_paid - $agreement->principal);

                    

                    if (($agreement->principal - $agreement->total_paid) <= 0) {
                        $agreement->status = 'completed';
                        // dd($agreement->status);
                    } else {
                        $agreement->status = 'active';
                        // dd($agreement->status);
                    }

                    $agreement->update();

                    $payment = new Payment();
                    $payment->customer_id = $pay['customer_id'];
                    $payment->agreement_id = $pay['agreement_id'];
                    $payment->employee_id = $pay['employee_id'];
                    $payment->amount_paid = $pay['amount_paid'];
                    $payment->cumulative_total_paid = $agreement->total_paid;
                    $payment->created_at = Carbon::parse($pay['created_at']);
                    $payment->save();
                }
            });

            return redirect()
                ->route('admin.payments')
                ->with(['type' => 'success', 'message' => 'Payments saved successfully']);
        } catch (ValidationException $e) {
            // Redirect back with validation errors

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log exception and reopen modal
            // dd($e->getMessage());
            Log::error('Agreement Store Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred while saving the payments.'])
                ->withinput();
        }
    }

    public function PaymentRecords()
    {
        try {
            $paymentsSummaries = Payment::selectRaw('agreement_id, SUM(amount_paid) as total_paid')->groupBy('agreement_id')->get();

            // dd($paymentsSummaries);
            return view('admin.hire_purchase.payments.summary', compact('paymentsSummaries'));
        } catch (\Exception $e) {
            Log::error('Payment Record  Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred while saving the payments.'])
                ->withinput();
        }
    }

    public function EditPayment($id){
        $payment = Payment::findOrFail($id);
        $employees = Employee::all();

        $agreements = Agreement::where('customer_id', $payment->customer_id)
            ->where(function ($query) {
                $query->whereColumn('principal', '>=', 'total_paid')->orWhere('principal', '=', 0);
            })
            ->get();

            // Return JSON response with agreements and employees
        return response()->json([
            'payment' => $payment,
            'employees' => $employees,
            'agreements' => $agreements->map(function ($agreement) {
                return [
                    'id' => $agreement->id,
                    'transaction_id' => $agreement->transaction_id,
                    'product_name' => $agreement->product->name,
                    'product_price' => $agreement->product->sale_price,
                    'down_payment' => $agreement->down_payment,
                    'employee_id' => $agreement->employee_id,
                ];
            }),
        ]);
    
    
    }

    public function UpdatePayment(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'customer_id' => 'required|exists:customers,id',
                'agreement_id' => 'required|exists:agreements,id',
                'employee_id' => 'required|exists:employees,id',
                'amount_paid' => 'required|numeric|min:0',
                'created_at' => 'required|date',
            ],
            [
                'customer_id.required' => 'Please select a customer.',
                'customer_id.exists' => 'The selected customer is invalid.',
                'agreement_id.required' => 'Please select an agreement.',
                'agreement_id.exists' => 'The selected agreement is invalid.',
                'employee_id.required' => 'Please select an employee.',
                'employee_id.exists' => 'The selected employee is invalid.',
                'amount_paid.required' => 'A amount paid is required.',
                'amount_paid.numeric' => 'The amount paid must be a number.',
                'amount_paid.min' => 'The amount paid must be at least 0.',
                'created_at.required' => 'The date is required.',
                'created_at.date' => 'Please enter a valid date.',
            ],
        );

        try {
            DB::transaction(function () use ($request) {
                // Find the payment to edit
                $payment = Payment::findOrFail($request->id);

                // Find the related agreement
                $agreement = Agreement::findOrFail($payment->agreement_id);

                // Adjust agreement's total_paid by removing the original payment amount
                $agreement->total_paid -= $payment->amount_paid;

                // Update the payment with new data
                $payment->customer_id = $request->customer_id;
                $payment->agreement_id = $request->agreement_id;
                $payment->employee_id = $request->employee_id;
                $payment->amount_paid = $request->amount_paid;
                $payment->created_at = Carbon::parse($request->created_at);
                $payment->updated_at = Carbon::parse(now());
                $payment->save();

                // Recalculate cumulative_total_paid for all payments in the agreement
                $cumulativeTotal = 0;
                $remainingPayments = Payment::where('agreement_id', $agreement->id)
                    ->orderBy('created_at')
                    ->get();

                foreach ($remainingPayments as $remainingPayment) {
                    $cumulativeTotal += $remainingPayment->amount_paid;
                    $remainingPayment->cumulative_total_paid = $cumulativeTotal;
                    $remainingPayment->update();
                }

                if (($agreement->principal - $agreement->total_paid) <= 0) {
                    $agreement->status = 'completed';
                    // dd($agreement->status);
                } else {
                    $agreement->status = 'active';
                    // dd($agreement->status);
                }

                // Update agreement status based on the model method
                // $agreement->updateStatus();

                // Update the agreement's total_paid to match the recalculated cumulative total
                $agreement->total_paid = $cumulativeTotal;
                $agreement->update();
            });

            return redirect()
                ->route('admin.payments')
                ->with(['type' => 'success', 'message' => 'Payment updated successfully']);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Payment not found.']);
        } catch (\Exception $e) {
            Log::error('Payment Edit Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred while updating the payment.']);
        }
    }

    public function deletePayment($id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Find the payment to be deleted
                $payment = Payment::findOrFail($id);

                // Find the related agreement
                $agreement = Agreement::find($payment->agreement_id);
                // dd($agreement);

                if ($agreement) {
                    // Delete the payment
                    $payment->delete();

                    // Recalculate cumulative_total_paid for remaining payments
                    $cumulativeTotal = 0;
                    $remainingPayments = Payment::where('agreement_id', $agreement->id)
                        ->orderBy('created_at')
                        ->get();

                    foreach ($remainingPayments as $remainingPayment) {
                        $cumulativeTotal += $remainingPayment->amount_paid;
                        $remainingPayment->cumulative_total_paid = $cumulativeTotal;
                        $remainingPayment->update();
                    }

                    // Update the agreement's total_paid
                    $agreement->total_paid = $cumulativeTotal;

                    if (($agreement->principal - $agreement->total_paid) <= 0) {
                        $agreement->status = 'completed';
                        // dd($agreement->status);
                    } else {
                        $agreement->status = 'active';
                        // dd($agreement->status);
                    }

                    $agreement->update();
                }
            });

            return redirect()
                ->route('admin.payments')
                ->with(['type' => 'success', 'message' => 'Payment deleted successfully and cumulative totals updated.']);
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Payment not found.']);
        } catch (\Exception $e) {
            Log::error('Payment Deletion Error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred while deleting the payment.']);
        }
    }
}
