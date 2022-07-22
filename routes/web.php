<?php

use App\Http\Controllers\ProductController;
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

// Frontend
Route::get('/', function () {
    return view('frontend.index');
})->name('frontend.home');
Route::get('/shop', [ProductController::class,"index"])->name('shop');
Route::get('/product/{slug}', [ProductController::class,"show"])->name('product.detail');

// User
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view("user.layouts.app");
    })->name('user.dashboard');
});

// Admin
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',"AuthAdmin"])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view("admin.layouts.app");
    })->name('admin.dashboard');
});
