<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\Livewire\CartManager;
use App\Livewire\MyOrders;
use App\Livewire\Profile;
use App\Livewire\ServiceDetail;
use App\Livewire\Services;
use App\Livewire\Order;
use App\Livewire\Orders;
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

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');

    Route::get('register', Register::class)->name('register');
});

Route::get('password/reset', Email::class)->name('password.request');

Route::get('password/reset/{token}', Reset::class)->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)->name('password.confirm');

    Route::get('profile', Profile::class)->name('profile');
    Route::get('services', Services::class)->name('services');
    Route::get('/service/{serviceId}', ServiceDetail::class)->name('service.detail');
    Route::get('/cart', CartManager::class)->name('cart-manager')->middleware('role:customer');
    Route::get('/order', Order::class)->name('order')->middleware('role:customer');
    Route::get('/my-orders', MyOrders::class)->name('my-orders')->middleware('role:customer');

    Route::get('/orders', Orders::class)->name('orders')->middleware('role:seller');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)->name('logout');
});
