<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function AllEmployees(){
        $employees = Employee::latest()->get();
        return view('admin.employees.index',compact('employees'));
    }

    public function AddEmployee()
    {
        return view('admin.employees.add');
    }

    // Single Employee Creation
    public function StoreEmployee(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => ['required', 'unique:employees,phone', 'regex:/^[0-9]{10}$/'],
                'address' =>'required'
                
            ], [
                'phone.regex' => 'Phone number must be exactly 10 digits.',
            ]);
            
    
            //Store the employee
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->save();

            return redirect()->back()->with(['type'=>'success','message'=>'Employee saved successfully']);
        }catch(ValidationException $e) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($e->errors())->withInput()->with('modal', 'employeeNewModal');
        }catch (\Exception $e) {
            // Log exception and reopen modal
            return redirect()->back()->with('modal', 'employeeNewModal');
        }
        
    }


    public function ShowEmployee($id)
    {
        $employee = Employee::find($id);
        return view('admin.employees.show.employee',compact('employee'));
    }

    public function EditEmployee($id)
    {
        $employee = Employee::find($id);
        return view('admin.employees.edit', compact('employee'));
    }

    public function UpdateEmployee(Request $request)
    {
        $employee = Employee::find($request->id);

        $request->validate([
            // 'name' => 'required|unique:employees,name,' . $employee->id,
            'name' => 'required',
            'phone' => 'required|unique:employees,name,' . $employee->id,
            'address' =>'required'
        ]);

        $employee->name = $request->name;
        $employee->address = $request->address;
        $employee->update();

        return redirect()->back('success', 'Employee updated successfully');
    }

    public function DeleteEmployee($id)
    {
        $employee = Employee::find($id);

        // Check if the employee has any employees
        if ($employee->agreement()->count() > 0) {
            return redirect()->back()->with('error', 'Employee cannot be deleted because it has Hire Purchase Agreement.');
        }

        // Delete the employee
        $employee->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully!');
    }

}
