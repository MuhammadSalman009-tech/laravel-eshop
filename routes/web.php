<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
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
Route::post('/sort-products/ajax', [ProductController::class,"sortProducts"])->name('sort.products');
Route::get('/category/{slug}', [ProductController::class,"productsByCategory"])->name('products.by.category');
// Cart
Route::get("/cart",[ProductController::class,"cart"])->name("cart");
Route::get("/add-to-cart/{id}",[ProductController::class,"addToCart"])->name("add.to.cart");
Route::patch("/update-cart",[ProductController::class,"updateCart"])->name("update.cart");
Route::delete('/remove-from-cart', [ProductController::class, 'removeFromCart'])->name('remove.from.cart');

// User
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view("user.layouts.app");
    })->name('user.dashboard');
});

// Admin
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',"AuthAdmin"])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view("admin.index");
    })->name('admin.dashboard');

    Route::resource('/admin/categories',CategoryController::class);
    Route::resource('/admin/products',AdminProductController::class);
});
