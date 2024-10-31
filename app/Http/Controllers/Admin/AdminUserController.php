<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Agreement;
use Carbon\Carbon;


class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin_users = AdminUser::get();

        $salesPerMonth =  Agreement::whereYear('start_date', Carbon::now()->year)
        ->whereMonth('start_date', Carbon::now()->month)
        ->sum('principal');

        dd($salesPerMonth);

        return view('admin.users.index',compact(['admin_users']));
    }


    

    public function Profile()
    {
        $admin = Auth::guard('admin')->id();
        $profile = AdminUser::find($admin)->first();
        return view('admin.profile.index',compact('profile'));
    }

    public function ProfileUpdate(Request $request)
    {
        // Validate Fields
       $request->validate([
            'name' => 'required|min:4',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' =>'nullable',
        ]);

     

        // Fetch Admin Profile
        $adminId = Auth::guard('admin')->id();
        $profile = AdminUser::find($adminId);

        // Update Profile Fields
        $profile->name = $request->name;
        $profile->username = $request->username;
        $profile->phone = $request->phone;
        $profile->email = $request->email;
        $profile->address = $request->address;

        // Handle Photo Upload
        $oldPhotoPath = $profile->photo;

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/images/uploads'),$filename);

            // Save New Photo Filename
            $profile->photo = $filename;

            //Delete old Photo if different from the new One
            if($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
            }
        }
        
        $profile->save();

        $notification = array(
            'message' =>  'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    private function deleteOldImage(string $oldPhotoPath):void
    {
        $fullPath = public_path('admin/assets/images/uploads'.$oldPhotoPath);
        if(file_exists($fullPath)){
            unlink($fullPath);
        }
    }

    public function ProfilePasswordUpdate(Request $request)
    {
         // Validate Fields
       $request->validate([
            'current_password' => 'required', // Conditionally required
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
       ]);

       // Fetch Admin Profile
       $adminId = Auth::guard('admin')->id();
       $profile = AdminUser::find($adminId);

        // Password Update Logic
        if(!Hash::check($request->current_password, $profile->password)){
                
            $notification = array(
                'message' => "Current Password Does Not Match!",
                'alert-type' => "error",
            );
            return back()->with($notification);

        }else{
            // Update password
            $profile->password = Hash::make($request->new_password);
            $profile->save();

            $notification = array(
                'message' =>  'Profile Password Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->back()->with($notification);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
