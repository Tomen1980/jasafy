<?php

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Livewire\Login;
use App\Livewire\Register;
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

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::get('tampil', function () {
    return 'Berhasil login regis';
})->middleware('auth');

// ================================================================
//POSTMAN
Route::get('/token', function () {
    return csrf_token();
});

route::post('/auth/login', [AuthController::class, 'login']);
route::post('/auth/register', [AuthController::class, 'register'])->name('register');

route::middleware('auth')->group(function () {
    // Logout
    route::delete('/auth/logout', [AuthController::class, 'logout']);
    // Update Profile
    route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    // Get Profile
    route::get('/auth/profile', [AuthController::class, 'getProfile']);
});
