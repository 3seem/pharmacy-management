<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AccountController;


// Route::middleware('auth')->group(
//     function () {
Route::get('/', function () {
    $medicine=DB::table('medicine')->get();
    $categories = DB::table('medicine')->select('Category')->distinct()->get();
    // dd($categories);
    return view('welcome', [
        "medicine" => $medicine,
        "categories" => $categories
    ]);
});

Route::get('/pharmacare', function () {
    $medicine=DB::table('medicine')->get();
    $categories = DB::table('medicine')->select('Category')->distinct()->get();
    // dd($categories);
    return view('pharmacare', [
        "medicine" => $medicine,
        "categories" => $categories
    ]);
});

Route::get('/cart', function () {
    return view('cart');
});

Route::post('/cart/add', [CartController::class, 'add'])->middleware('auth')->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->middleware('auth')->name('cart.show');
Route::post('/cart/update', [CartController::class, 'update'])->middleware('auth')->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->middleware('auth')->name('cart.remove');


Route::get('/account', function () {
    return view('account');
}); 

Route::put('/account/update', [AccountController::class, 'update'])
    ->name('account.update')
    ->middleware('auth');


Route::get('/product_details/{id}', function ($medicine_id=id) {
    $medicine=DB::table('medicine')->where('medicine_id', $medicine_id)->first();
    return view('product_details',["medicine"=>$medicine]);
})->name("product_details");
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
