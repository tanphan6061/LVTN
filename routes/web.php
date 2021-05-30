<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   return redirect()->route('login');
});

Auth::routes();
Route::group(['prefix' => '/admin', 'middleware' => ['auth']], function () {
    Route::resource('products', ProductController::class);
    Route::resource('discounts', DiscountController::class);
    Route::resource('orders', OrderController::class);
    // suppliers
    Route::get('view-profile', [SupplierController::class, 'show'])->name('suppliers.show');
    Route::get('edit-profile', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('edit-profile', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::get('change-password', [SupplierController::class, 'changePassword'])->name('suppliers.changePassword');
    Route::post('change-password', [SupplierController::class, 'updatePassword'])->name('suppliers.updatePassword');

    Route::get('manage-suppliers',[SupplierController::class, 'index'])->name('suppliers.index');
});
Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin');
