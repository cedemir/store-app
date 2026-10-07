<?php
use Illuminate\Support\Facades\Route;


Route::get('hello-world', [\App\Http\Controllers\HelloWorldController::class,'index']);
Route::redirect('/', 'login');
Route::get('/loja', [\App\Http\Controllers\Site\HomeController::class, 'index'])->name('site.home');
Route::get('/product/{product:slug}', [\App\Http\Controllers\Site\HomeController::class, 'single'])->name('site.single');

Route::redirect('l', 'login');
Route::view('login', 'auth.login')->name('login.view');
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register.index');
Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

Route::prefix('cart')->name('site.cart.')->group(function(){
    Route::get('/', [\App\Http\Controllers\Site\CartController::class, 'index'])->name('index');
    Route::post('/add', [\App\Http\Controllers\Site\CartController::class, 'add'])->name('add');
    Route::delete('/remove/{item}', [\App\Http\Controllers\Site\CartController::class, 'remove'])->name('remove');
    Route::get('/cancel', [\App\Http\Controllers\Site\CartController::class, 'cancel'])->name('cancel');
});

Route::prefix('checkout')->name('site.checkout.')->middleware('auth')->group(function(){
    Route::get('/', [\App\Http\Controllers\Site\CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [\App\Http\Controllers\Site\CheckoutController::class, 'process'])->name('process');
    Route::get('/thanks/{order}',  [\App\Http\Controllers\Site\CheckoutController::class, 'thanks'])->name('thanks');
});

Route::prefix('admin')->middleware('auth', 'can:can_access_manager')->group(function () {

    Route::get('/', \App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)
          ->except(['create', 'store']);

    Route::resource('products/{product}/photos', \App\Http\Controllers\Admin\ProductPhotoController::class)
          ->only(['index', 'store', 'destroy']);
});

Route::middleware('auth')->prefix('customers')->name('customers.')->group(function(){
    Route::get('my-orders', [\App\Http\Controllers\Customer\MyOrdersController::class, 'index'])->name('my-orders');

    Route::put('my-orders/cancel/{order}', [\App\Http\Controllers\Customer\MyOrdersController::class, 'cancelOrder'])
    ->can('update', 'order')
    ->name('my-orders.cancel');
});
