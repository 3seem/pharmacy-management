<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\medicines;
use App\Http\Controllers\audit_logs;
use App\Http\Controllers\batches;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\orders;
use App\Http\Controllers\price_change_logs;
use App\Http\Controllers\Suplliers;
use App\Http\Controllers\usermange;
use App\Models\supplier;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Cart;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\ChatController;



Route::post('/checkout', [orders::class, 'checkoutFromCart'])
    ->middleware('auth')
    ->name('checkout.cart');

Route::middleware('auth')->group(function () {

    Route::get('/cart', [Cart::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add', [Cart::class, 'add'])
        ->name('cart.add');

    Route::post('/cart/update', [Cart::class, 'update'])
        ->name('cart.update');

    Route::post('/cart/remove', [Cart::class, 'remove'])
        ->name('cart.remove');
});
Route::get('/', function () {
    $medicine = DB::table('medicines')->get();
    $categories = DB::table('medicines')->select('Category')->distinct()->get();
    // dd($categories);
    return view('welcome', [
        "medicine" => $medicine,
        "categories" => $categories
    ]);
});
Route::middleware('auth')->group(
    function () {
        Route::get('/pharmacare', function () {
            $medicine = DB::table('medicines')->get();
            $categories = DB::table('medicines')->select('Category')->distinct()->get();
            // dd($categories);
            return view('pharmacare', [
                "medicine" => $medicine,
                "categories" => $categories
            ]);
        })->name('home');





Route::get('/search', [ProductController::class, 'search'])->name('products.search');




Route::get('/account', function () {
    return view('account');
});

Route::put('/account/update', [AccountController::class, 'update'])
    ->name('account.update')
    ->middleware('auth');


Route::get('/product_details/{id}', function ($medicine_id = id) {
    $medicine = DB::table('medicines')->where('medicine_id', $medicine_id)->first();
    return view('product_details', ["medicine" => $medicine]);
})->name("product_details");
    }
);




//chat
// Route::middleware(['auth'])->group(function () {

//     Route::get('/chat/{conversation}', [ChatController::class, 'show'])
//         ->name('chat.show');

//     Route::post('/chat/send', [ChatController::class, 'send'])
//         ->name('chat.send');

//     Route::get('/chat/{conversation}/messages', [ChatController::class, 'fetchMessages'])
//         ->name('chat.messages');

// });

Route::middleware(['auth'])->group(function () {

    Route::get('/my-chats', [ChatController::class, 'myChats'])->name('chat.list');

    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversation}/messages', [ChatController::class, 'fetchMessages'])->name('chat.messages');
    Route::post('/chat/start', [ChatController::class, 'startChat'])->name('chat.start');

});





// Admin




//chat
Route::middleware(['auth'])->group(function () {

    Route::get('/my-chats', [ChatController::class, 'myChats'])->name('chat.list');

    Route::get('/admin/chats', [ChatController::class, 'adminChats'])->name('admin.chat.list');

    Route::get('/chat/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversation}/messages', [ChatController::class, 'fetchMessages'])->name('chat.messages');

});



Route::middleware(['auth', 'verified', IsAdmin::class])->group(
    function () {
        Route::get(
            '/admin-dashboard',
            [DashboardController::class, 'index']
        )->name('admin.dashboard');

        Route::post('/orders/{order}/complete', [App\Http\Controllers\orders::class, 'markCompleted'])
            ->name('orders.complete');

        // audit_logs done
        Route::get(
            '/audit_logs',
            [audit_logs::class, 'audit']
        )->name('admin.audit_logs');




        // batches
        Route::get('/batches', [batches::class, 'index'])
            ->name('admin.batches');

        Route::get('/batches/add', [batches::class, 'create'])
            ->name('admin.batches.add');

        Route::post('/batches/store', [batches::class, 'store'])
            ->name('admin.batches.store');

        Route::delete('/batches/{batch_number}', [batches::class, 'destroy'])
            ->name('admin.batches.destroy');

















        // price - change done 
        Route::get(
            '/admin-price-change',
            [price_change_logs::class, 'audit']
        )->name('admin.price_logs');








        // medicines done 

        Route::get(
            '/medicine',
            [medicines::class, 'medcine']
        )->name('admin.medicine');
        Route::get('/medicine/add', [medicines::class, 'create'])->name('admin.medicine.add');
        Route::post('/medicine/store', [medicines::class, 'store'])->name('admin.medicine.store');
        Route::delete('/medicine/{medicine}', [medicines::class, 'destroy'])->name('admin.medicine.destroy');
        Route::get('/medicine/{medicine}', [medicines::class, 'edit'])->name('admin.medicine.edit');
        Route::put('/medicine/{medicine}', [medicines::class, 'update'])
            ->name('admin.medicine.update');






        // orders done 

        Route::get(
            '/orders',
            [orders::class, 'orders']
        )->name('admin.orders');
        Route::delete('/orders/{id}', [orders::class, 'destroy'])->name('orders.destroy');
        Route::get('/orders/{order}/edit', [orders::class, 'edit'])->name('orders.edit');
        Route::post('/orders/{order}/update-items', [orders::class, 'updateItems'])->name('orders.updateItems');

        Route::delete('/orders/{order}/items/{medicine}', [orders::class, 'deleteItem'])->name('orders.items.delete');
        Route::get('/orders/create', [orders::class, 'create'])->name('orders.create');
        Route::post('/orders', [orders::class, 'store'])->name('orders.store');
        Route::post('/orders/store', [orders::class, 'store'])
            ->name('orders.store');















        // Suplliers done 
        Route::get(
            '/suppliers',
            [Suplliers::class, 'suppliers']
        )->name('admin.suppliers');
        Route::get('/admin/suppliers/create', [Suplliers::class, 'create'])->name('admin.suppliers.create');
        Route::post('/admin/suppliers/store', [Suplliers::class, 'store'])->name('admin.suppliers.store');
        Route::delete('/supplier/{supplier}', [Suplliers::class, 'destroy'])->name('admin.suppliers.destroy');
        Route::get('/supplier/{supplier}', [Suplliers::class, 'edit'])->name('admin.suppliers.edit');
        Route::put('/supplier/{supplier}', [Suplliers::class, 'update'])->name('admin.suppliers.update');







        // usermanagement

        Route::get(
            '/usermanagement',
            [usermange::class, 'user']
        )->name('admin.usermanagement');
        Route::get('/users/customer/create', [usermange::class, 'createcust'])->name('admin.customer.create');
        Route::get('/users/employee/create', [usermange::class, 'createemp'])->name('admin.employee.create');
        Route::post('/users/customer/store', [usermange::class, 'storeCustomer'])
            ->name('admin.customers.store');

        Route::post('/users/employee/store', [usermange::class, 'storeEmployee'])
            ->name('admin.employees.store');
        Route::delete('/users/{id}/delete', [usermange::class, 'deleteUser'])
            ->name('users.delete');

        Route::get('/users/customer/{id}/edit', [usermange::class, 'editCustomer'])
            ->name('users.customer.edit');

        Route::post('/users/customer/{id}/update', [usermange::class, 'updateCustomer'])
            ->name('users.customer.update');

        // -------- EMPLOYEE --------
        Route::get('/users/employee/{id}/edit', [usermange::class, 'editEmployee'])
            ->name('users.employee.edit');

        Route::post('/users/employee/{id}/update', [usermange::class, 'updateEmployee'])
            ->name('users.employee.update');
    }
);







Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
