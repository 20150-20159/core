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

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return redirect(route('login'));
});

Route::get('/dashboard', [DashboardController::class, 'home'])->name('dashboard.home');
Route::get('/dashboard/properties', [DashboardController::class, 'properties'])->name('dashboard.home');

Route::post('/properties/initiateTransfer/{property}', [PropertyController::class, 'initiateTransfer'])->name('properties.initiateTransfer');
Route::get('/properties/approveTransfer/{property}', [PropertyController::class, 'approveTransfer'])->name('properties.approve');
Route::get('/properties/rejectTransfer/{property}', [PropertyController::class, 'rejectTransfer'])->name('properties.reject');
Route::get('/properties/deed/{property}', [PropertyController::class, 'deed'])->name('properties.deed');

Route::get('/dashboard/admin/properties', [AdminController::class, 'properties'])->name('admin.properties');
Route::delete('/properties/{id}', [PropertyController::class, 'destroy'])->name('admin.properties.destroy');
Route::get('/properties/cancel/{property}', [PropertyController::class, 'cancelTransfer'])->name('admin.properties.cancel');

//Accounts
Route::get('/login',[AuthenticationController::class, 'loginShow'])->name('login.show');
Route::post('/login',[AuthenticationController::class, 'login'])->name('login');
Route::get('/register',[AuthenticationController::class, 'registerShow'])->name('register.show');
Route::post('/register',[AuthenticationController::class, 'register'])->name('register');
Route::get('/logout',[AuthenticationController::class, 'logout'])->name('logout');


