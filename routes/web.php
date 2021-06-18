<?php

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

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
   return view('master');
});

Route::get('/dashboard/listings', [DashboardController::class, 'listings'])->name('dashboard.home');

//Accounts
Route::get('/login',[AuthenticationController::class, 'loginShow'])->name('login.show');
Route::post('/login',[AuthenticationController::class, 'login'])->name('login');
Route::get('/logout',[AuthenticationController::class, 'logout'])->name('logout');


