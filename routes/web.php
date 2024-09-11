<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController ;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminUserController;



// Auth
Route::post('/admin/login',[AdminAuthController::class,'login'])
        ->name('admin.login.submit');


Route::prefix('admin')->group(function(){
        Route::get('/login',[AdminAuthController::class,'index'])->name('admin.login');
        Route::get('/forget-password',[AdminAuthController::class,'forget_password'])
        ->name('admin.forget_password');
        Route::post('/forget-password',[AdminAuthController::class,'forget_password_submit'])
        ->name('admin.forget.password.submit');
        Route::get('/reset-password/{token}/{email}',[AdminAuthController::class,'reset_password'])->name('admin.reset.password');
        Route::patch('/reset-password/{token}/{email}',[AdminAuthController::class,'reset_password_form'])->name('admin.reset.password.submit');
});

// Admin Middleware
Route::middleware('admin')->prefix('admin')->group(function(){
        Route::get('/dashboard', [AdminDashboardController ::class,'index'])->name('admin.dashboard');
        Route::get('/logout',[AdminAuthController::class,'logout'])->name('admin.logout');
        Route::get('/users',[AdminUserController::class,'index'])->name('admin.users');

        // Permissions Routes
       
});