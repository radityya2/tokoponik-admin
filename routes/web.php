<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', fn() => view('auth.login'))->name('login');

// Protected routes
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // User Management Routes
    Route::prefix('user')->group(function () {
        Route::get('/', fn() => view('manage-user.index'))->name('user.index');
        Route::get('/create', fn() => view('manage-user.create'))->name('user.create');
        Route::get('/{id}/edit', fn($id) => view('manage-user.edit'))->name('user.edit');
        Route::get('/destroy/{id}', fn($id) => redirect()->route('user.index'))->name('user.destroy');
        Route::post('/store', fn() => redirect()->route('user.index'))->name('user.store');
        Route::put('/update/{id}', fn($id) => redirect()->route('user.index'))->name('user.update');
    });

    // Product Management Routes
    Route::prefix('product')->group(function () {
        Route::get('/', fn() => view('manage-product.index'))->name('product.index');
        Route::get('/create', fn() => view('manage-product.create'))->name('product.create');
        Route::get('/{id}/edit', fn($id) => view('manage-product.edit'))->name('product.edit');
        Route::post('/store', fn() => redirect()->route('product.index'))->name('product.store');
        Route::delete('/destroy/{id}', fn($id) => redirect()->route('product.index'))->name('product.destroy');
    });

    // Address Management Routes
    Route::prefix('address')->group(function () {
        Route::get('/{user_id}', fn($user_id) => view('manage-address.index'))->name('address.index');
        Route::get('/create/{user_id}', fn($user_id) => view('manage-address.create'))->name('address.create');
        Route::get('/{id}/edit', fn($id) => view('manage-address.edit'))->name('address.edit');
        Route::get('/destroy/{id}', fn($id) => redirect()->route('address.index'))->name('address.destroy');
        Route::post('/store/{user_id}', fn($user_id) => redirect()->route('address.index', $user_id))->name('address.store');
        Route::put('/update/{id}', fn($id) => redirect()->route('address.index'))->name('address.update');
    });

    // Blog Management Routes
    Route::prefix('blog')->group(function () {
        Route::get('/', fn() => view('manage-blog.index'))->name('blog.index');
        Route::get('/create', fn() => view('manage-blog.create'))->name('blog.create');
        Route::get('/{id}/edit', fn($id) => view('manage-blog.edit'))->name('blog.edit');
        Route::post('/store', fn() => redirect()->route('blog.index'))->name('blog.store');
        Route::put('/update/{id}', fn($id) => redirect()->route('blog.index'))->name('blog.update');
        Route::delete('/destroy/{id}', fn($id) => redirect()->route('blog.index'))->name('blog.destroy');
    });

    // Transaction Management Routes
    Route::prefix('transaction')->group(function () {
        Route::get('/', fn() => view('manage-transaction.index'))->name('transaction.index');
        Route::get('/create', fn() => view('manage-transaction.create'))->name('transaction.create');
        Route::get('/edit/{id}', fn($id) => view('manage-transaction.edit'))->name('transaction.edit');
        Route::post('/store', fn() => redirect()->route('transaction.index'))->name('transaction.store');
        Route::post('/transaction/update-status/{id}', fn($id) => response()->json(['success' => true]))->name('transaction.updateStatus');
        Route::put('/update/{id}', fn($id) => redirect()->route('transaction.index'))->name('transaction.update');
        Route::delete('/destroy/{id}', fn($id) => redirect()->route('transaction.index'))->name('transaction.destroy');
    });

    // Bank Management Routes
    Route::prefix('bank')->group(function () {
        Route::get('/', fn() => view('manage-bank.index'))->name('bank.index');
        Route::get('/create', fn() => view('manage-bank.create'))->name('bank.create');
        Route::get('/{id}/edit', fn($id) => view('manage-bank.edit'))->name('bank.edit');
        Route::post('/store', fn() => redirect()->route('bank.index'))->name('bank.store');
        Route::put('/update/{id}', fn($id) => redirect()->route('bank.index'))->name('bank.update');
        Route::delete('/destroy/{id}', fn($id) => redirect()->route('bank.index'))->name('bank.destroy');
    });
});
