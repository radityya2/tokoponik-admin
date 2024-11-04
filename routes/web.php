<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});

Route::prefix('address')->group(function () {
    Route::get('/{user_id}', [AddressController::class, 'index'])->name('address.index');
    Route::get('/create/{user_id}', [AddressController::class, 'create'])->name('address.create');
    Route::post('/store/{user_id}', [AddressController::class, 'store'])->name('address.store');
    Route::get('/edit/{id}', [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/update/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::get('/destroy/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
});


Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('/destroy/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
});
