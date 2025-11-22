<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth')->group(
//     function () {
Route::get('/', function () {
    return view('welcome');
});

Route::get('/pharmacare', function () {
    return view('pharmacare');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/account', function () {
    return view('account');
});

Route::get('/product_details', function () {
    return view('product_details');
});
//     }
// );

Route::get('/admin-dashboard', function () {
    return view('admin.admin-dashboard');
});

Route::get('/medicine', function () {
    return view('admin.medicine');
});



Route::get('/orders', function () {
    return view('admin.orders');
});

Route::get('/sales', function () {
    return view('admin.sales');
});

Route::get('/suppliers', function () {
    return view('admin.suppliers');
});

Route::get('/usermanagement', function () {
    return view('admin.usermanagement');
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
