<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'home']);

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/dashboard', [HomeController::class, 'login_home'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/my_orders', [HomeController::class, 'my_orders'])
    ->middleware(['auth', 'verified']);

Route::get('user_product_search', [HomeController::class, 'user_product_search']);

Route::get('filter_products', [HomeController::class, 'filter_products']);

// Route::get('user_product_search', [HomeController::class, 'user_product_search'])
//     ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'admin']);


Route::get('view_category', [AdminController::class, 'view_category'])
    ->middleware(['auth', 'admin']);

Route::post('add_category', [AdminController::class, 'add_category'])
    ->middleware(['auth', 'admin']);

Route::get('delete_category/{id}', [AdminController::class, 'delete_category'])
    ->middleware(['auth', 'admin']);

Route::get('edit_category/{id}', [AdminController::class, 'edit_category'])
    ->middleware(['auth', 'admin']);

Route::post('update_category/{id}', [AdminController::class, 'update_category'])
    ->middleware(['auth', 'admin']);

Route::get('add_product', [AdminController::class, 'add_product'])
    ->middleware(['auth', 'admin']);

Route::post('upload_product', [AdminController::class, 'upload_product'])
    ->middleware(['auth']);

Route::get('view_product', [AdminController::class, 'view_product'])
    ->middleware(['auth', 'admin']);

Route::get('delete_product/{id}', [AdminController::class, 'delete_product'])
    ->middleware(['auth', 'admin']);

Route::get('edit_product/{slug}', [AdminController::class, 'edit_product'])
    ->middleware(['auth', 'admin']);

Route::post('update_product/{id}', [AdminController::class, 'update_product'])
    ->middleware(['auth', 'admin']);

Route::get('product_search', [AdminController::class, 'product_search'])
    ->middleware(['auth', 'admin']);

Route::get('order_search', [AdminController::class, 'order_search'])
    ->middleware(['auth', 'admin']);

Route::get('product_details/{id}', [HomeController::class, 'product_details']);

Route::get('user_order_details/{id}', [HomeController::class, 'user_order_details']);

Route::get('shop', [HomeController::class, 'shop']);
Route::get('why_us', [HomeController::class, 'why_us']);

Route::get('contact', [HomeController::class, 'contact']);

Route::post('add_cart/{id}', [HomeController::class, 'add_cart'])
    ->middleware(['auth', 'verified']);

Route::get('view_cart', [HomeController::class, 'view_cart'])
    ->middleware(['auth', 'verified']);

Route::delete('delete_cart_item/{id}', [HomeController::class, 'delete_cart_item'])
    ->middleware(['auth', 'verified']);

Route::post('confirm_order', [HomeController::class, 'confirm_order'])
    ->middleware(['auth', 'verified']);

Route::get('view_orders', [AdminController::class, 'view_orders'])
    ->middleware(['auth', 'admin']);

Route::get('order_details/{id}', [AdminController::class, 'order_details'])
    ->middleware(['auth', 'admin']);

Route::get('on_the_way/{id}', [AdminController::class, 'on_the_way'])
    ->middleware(['auth', 'admin']);

Route::get('delivered/{id}', [AdminController::class, 'delivered'])
    ->middleware(['auth', 'admin']);

Route::get('view_users', [AdminController::class, 'view_users'])
    ->middleware(['auth', 'admin']);

Route::get('delete_user/{id}', [AdminController::class, 'delete_user'])
    ->middleware(['auth', 'admin']);

Route::get('user_search', [AdminController::class, 'user_search'])
    ->middleware(['auth', 'admin']);

    
Route::controller(PaymentController::class)->group(function(){
    Route::get('stripe/{value}', 'stripe');
    Route::post('stripe/{value}', 'stripePost')->name('stripe.post');
});

Route::post('update_cart_ajax/{id}', [HomeController::class, 'update_cart_ajax'])
    ->middleware(['auth', 'verified']);


Route::get('/status', function (Request $request) {
    return response()->json(['status' => 'ok'], 200);
});