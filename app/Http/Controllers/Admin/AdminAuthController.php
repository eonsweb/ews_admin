<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


use App\Mail\Websitemail;
use App\Models\AdminUser;



class AdminAuthController extends Controller
{
    


    public function index()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if(auth::guard('admin')->attempt($credentials)){

            return redirect()->route('admin.dashboard')->with('success','Login is successful');
        }else{
            return redirect()->route('admin.login')->with('error','Login Credentials Do Not Match');
        }
    }

    public function forget_password()
    {
        return view('admin.auth.forget_password');
    }

    public function forget_password_submit(Request $request){
       
        $request->validate([
            'email' => ['required','email']
        ]);

        $admin = AdminUser::where('email',$request->email)->first();

        if(!$admin){
            return redirect()->back()->with('error','Email Not Found');
        }

        $token = Hash('sha256',time());
        $admin->remember_token = $token;
        $admin->update();

        $reset_link = url('admin/reset-password/'.$token.'/'.$request->email);
        $subject = "Password Reset";
        $message = "To reset password, please click on the link below:<br>";
        $message .= "<a href='".$reset_link."'> Click Here </a>";

        \Mail::to($request->email)->send(new Websitemail($subject,$message));

        return redirect()->back()
            ->with('success','We have sent a password reset link to your email. Please check you email. If you do not find the mail in your inbox, please check your spam folder.');

    }

    public function reset_password($token,$email){
        $admin = AdminUser::where('email',$email)->where('remember_token',$token)->first();
       

        if(!$admin){
            return redirect()->route('admin.login')->with('error','Invalid Token or Email');
        }
        return view('admin.auth.reset_password_form',['email'=>$email,'token'=>$token]);
    }

    public function reset_password_form(Request $request){
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $admin = AdminUser::where('email',$request->email)->where('remember_token',$request->token)->first();
        $admin->password = Hash::make($request->password);
        $admin->remember_token = "";
        $admin->update();

        return redirect()->route('admin.login')->with('success','Password Ressetted');
    }

    public function logout(){
        auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success','Logout successful');
    }

   
}
