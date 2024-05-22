<?php

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;

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


Route::get("tampil",function(){
  return "Berhasil login regis";
})->middleware("auth");