<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



// Admin User Route List : Authentication
Route::prefix('admin')->group(function(){
    Route::get('/login',[AdminAuthController::class,'AdminLogin'])
        ->name('admin.login');
    Route::post('/login',[AdminAuthController::class,'AdminLoginSubmit'])
        ->name('admin.login.submit');
    Route::get('/forget-password',[AdminAuthController::class,'ForgetPassword'])
        ->name('admin.forget.password');
    Route::post('/forget-password',[AdminAuthController::class,'ForgetPasswordSubmit'])
        ->name('admin.forget.password.submit');
    Route::get('/reset-password/{token}/{email}',[AdminAuthController::class,'ResetPassword'])
        ->name('admin.reset.password');
    Route::patch('/reset-password/{token}/{email}',[AdminAuthController::class,'ResetPasswordSubmit'])
        ->name('admin.reset.password.submit');

});

// Admin User Route List with Middleware
Route::middleware('admin')->prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminUserController::class,'AdminDashboard'])
        ->name('admin.dashboard');
    Route::get('/logout',[AdminAuthController::class,'Logout'])
        ->name('admin.logout');
    Route::get('/profile',[AdminUserController::class,'Profile'])
        ->name('admin.profile');
    Route::patch('/profile',[AdminUserController::class,'ProfileUpdate'])
        ->name('admin.profile.update');
    Route::patch('/profilepasswordupdate',[AdminUserController::class,'ProfilePasswordUpdate'])
        ->name('admin.profile.password.update');

});