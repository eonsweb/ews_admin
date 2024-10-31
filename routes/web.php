<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AgreementController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin User Route List : Authentication
Route::get('/', [AdminAuthController::class, 'AdminLogin'])->name('home');
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'AdminLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'AdminLoginSubmit'])->name('admin.login.submit');
    Route::get('/forget-password', [AdminAuthController::class, 'ForgetPassword'])->name('admin.forget.password');
    Route::post('/forget-password', [AdminAuthController::class, 'ForgetPasswordSubmit'])->name('admin.forget.password.submit');
    Route::get('/reset-password/{token}/{email}', [AdminAuthController::class, 'ResetPassword'])->name('admin.reset.password');
    Route::patch('/reset-password/{token}/{email}', [AdminAuthController::class, 'ResetPasswordSubmit'])->name('admin.reset.password.submit');
});

// Admin User Route List with Middleware
Route::middleware('admin')
    ->prefix('admin')
    ->group(function () {
        // Route::get('/dashboard', [AdminUserController::class, 'AdminDashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminAuthController::class, 'Logout'])->name('admin.logout');
        Route::get('/profile', [AdminUserController::class, 'Profile'])->name('admin.profile');
        Route::patch('/profile', [AdminUserController::class, 'ProfileUpdate'])->name('admin.profile.update');
        Route::patch('/profilepasswordupdate', [AdminUserController::class, 'ProfilePasswordUpdate'])->name('admin.profile.password.update');
    
    });
    
    Route::middleware(['admin'])->prefix('admin')->group(function(){

        Route::controller(DashboardController::class)->group(function(){
            Route::get('/dashboard','AdminDashboard')->name('admin.dashboard');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'AllCategories')->name('admin.categories');
            Route::get('/category/add', 'AddCategory')->name('admin.category.add');
            Route::post('/category/store', 'StoreCategory')->name('admin.category.store');
            Route::get('/category/{id}/edit', 'EditCategory')->name('admin.category.edit');
            Route::patch('/category/{id}/update', 'UpdateCategory')->name('admin.category.update');
            Route::get('/category/{id}/delete', 'DeleteCategory')->name('admin.category.delete');

            Route::get('/categories/import','ImportCategories')->name('admin.categories.import');
            Route::post('/categories/import/store', 'StoreImportedCategories')->name('admin.categories.import.store');
        });
        Route::controller(EmployeeController::class)->group(function () {
            Route::get('/employees', 'AllEmployees')->name('admin.employees');
            Route::get('/employee/add', 'AddEmployee')->name('admin.employee.add');
            Route::post('/employee/store', 'StoreEmployee')->name('admin.employee.store');
            Route::get('/employee/{id}/edit', 'EditEmployee')->name('admin.employee.edit');
            Route::get('/employee/{id}/show', 'ShowEmployee')->name('admin.employee.show');
            Route::patch('/employee/{id}/update', 'UpdateEmployee')->name('admin.employee.update');
            Route::get('/employee/{id}/delete', 'DeleteEmployee')->name('admin.employee.delete');

        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'AllProducts')->name('admin.products');
            Route::get('/product/add', 'AddProduct')->name('admin.product.add');
            Route::post('/product/store', 'StoreProduct')->name('admin.product.store');
            Route::get('/product/{id}/edit', 'EditProduct')->name('admin.product.edit');
            Route::patch('/product/{id}/update', 'UpdateProduct')->name('admin.product.update');
            Route::get('/product/{id}/delete', 'DeleteProduct')->name('admin.product.delete');

            Route::get('/products/import','ImportProducts')->name('admin.products.import');
            Route::post('/products/import/store', 'StoreImportedProducts')->name('admin.products.import.store');
        });
        Route::controller(CustomerController::class)->group(function () {
            Route::get('/customers', 'AllCustomers')->name('admin.customers');
            Route::get('/customer/add', 'AddCustomer')->name('admin.customer.add');
            Route::post('/customer/store', 'StoreCustomer')->name('admin.customer.store');
            Route::get('/customer/{id}/edit', 'EditCustomer')->name('admin.customer.edit');
            Route::get('/customer/{id}/show', 'ShowCustomer')->name('admin.customer.show');
            Route::patch('/customer/{id}/update', 'UpdateCustomer')->name('admin.customer.update');
            Route::get('/customer/{id}/delete', 'DeleteCustomer')->name('admin.customer.delete');

            Route::get('/customers/import','ImportCustomers')->name('admin.customers.import');
            Route::post('/customers/import/store', 'StoreImportedCustomers')->name('admin.customers.import.store');
        });
        Route::controller(AgreementController::class)->group(function () {
            Route::get('/agreements', 'AllAgreements')->name('admin.agreements');
            Route::get('/agreement/add', 'AddAgreement')->name('admin.agreement.add');
            Route::post('/agreement/store', 'StoreAgreement')->name('admin.agreement.store');
            Route::get('/agreement/{id}/edit', 'EditAgreement')->name('admin.agreement.edit');
            Route::get('/agreement/{id}/show', 'ShowAgreement')->name('admin.agreement.show');
            Route::patch('/agreement/{id}/update', 'UpdateAgreement')->name('admin.agreement.update');
            Route::get('/agreement/{id}/delete', 'DeleteAgreement')->name('admin.agreement.delete');

        });
        Route::controller(PaymentController::class)->group(function () {
            Route::get('/payments', 'AllPayments')->name('admin.payments');
            Route::get('/payment/add', 'AddPayment')->name('admin.payment.add');
            Route::post('/payment/store', 'StorePayment')->name('admin.payment.store');
            Route::get('/payment/{id}/edit', 'EditPayment')->name('admin.payment.edit');
            Route::get('/payment/{id}/show', 'ShowPayment')->name('admin.payment.show');
            Route::patch('/payment/{id}/update', 'UpdatePayment')->name('admin.payment.update');
            Route::get('/payment/{id}/delete', 'DeletePayment')->name('admin.payment.delete');

            Route::get('/payment/records', 'PaymentRecords')->name('admin.payment.records');

            Route::get('/payment/customer-transactions/{customerId}', 'GetAgreements')->name('admin.agreement.customer-transactions');
        });

        
    });

    // Route::get('/dashboard', [AdminUserController::class, 'AdminDashboard'])->name('admin.dashboard');