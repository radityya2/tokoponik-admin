<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

// Protected routes
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('user')->group(function () {
        Route::get('/', function() {
            return view('manage-user.index');
        })->name('user.index');

        Route::get('/create', function() {
            return view('manage-user.create');
        })->name('user.create');

        Route::post('/store', function() {
            return redirect()->route('user.index');
        })->name('user.store');

        Route::get('/edit/{id}', function($id) {
            return view('manage-user.edit');
        })->name('user.edit');

        Route::put('/update/{id}', function($id) {
            return redirect()->route('user.index');
        })->name('user.update');

        Route::get('/destroy/{id}', function($id) {
            return redirect()->route('user.index');
        })->name('user.destroy');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', function() {
            return view('manage-product.index');
        })->name('product.index');

        Route::get('/create', function() {
            return view('manage-product.create');
        })->name('product.create');

        Route::post('/store', function() {
            return redirect()->route('product.index');
        })->name('product.store');


        Route::put('/update/{id}', function($id) {
            return redirect()->route('product.index');
        })->name('product.update');

        Route::delete('/destroy/{id}', function($id) {
            return redirect()->route('product.index');
        })->name('product.destroy');

        Route::get('/{id}/edit', function($id) {
            return view('manage-product.edit');
        })->name('product.edit');
    });

    Route::prefix('address')->group(function () {
        Route::get('/{user_id}', function($user_id) {
            return view('manage-address.index');
        })->name('address.index');

        Route::get('/create/{user_id}', function($user_id) {
            return view('manage-address.create');
        })->name('address.create');

        Route::post('/store/{user_id}', function($user_id) {
            return redirect()->route('address.index', $user_id);
        })->name('address.store');

        Route::get('/edit/{id}', function($id) {
            return view('manage-address.edit');
        })->name('address.edit');

        Route::put('/update/{id}', function($id) {
            return redirect()->route('address.index');
        })->name('address.update');

        Route::get('/destroy/{id}', function($id) {
            return redirect()->route('address.index');
        })->name('address.destroy');
    });

    Route::prefix('blog')->group(function () {
        Route::get('/', function() {
            return view('manage-blog.index');
        })->name('blog.index');

        Route::get('/create', function() {
            return view('manage-blog.create');
        })->name('blog.create');

        Route::post('/store', function() {
            return redirect()->route('blog.index');
        })->name('blog.store');

        Route::get('/edit/{id}', function($id) {
            return view('manage-blog.edit');
        })->name('blog.edit');

        Route::put('/update/{id}', function($id) {
            return redirect()->route('blog.index');
        })->name('blog.update');

        Route::delete('/destroy/{id}', function($id) {
            return redirect()->route('blog.index');
        })->name('blog.destroy');
    });

    Route::prefix('transaction')->group(function () {
        Route::get('/', function() {
            return view('manage-transaction.index');
        })->name('transaction.index');

        Route::get('/create', function() {
            return view('manage-transaction.create');
        })->name('transaction.create');

        Route::post('/store', function() {
            return redirect()->route('transaction.index');
        })->name('transaction.store');

        Route::get('/edit/{id}', function($id) {
            return view('manage-transaction.edit');
        })->name('transaction.edit');

        Route::put('/update/{id}', function($id) {
            return redirect()->route('transaction.index');
        })->name('transaction.update');

        Route::delete('/destroy/{id}', function($id) {
            return redirect()->route('transaction.index');
        })->name('transaction.destroy');

        Route::post('/transaction/update-status/{id}', function($id) {
            return response()->json(['success' => true]);
        })->name('transaction.updateStatus');
    });

    Route::prefix('bank')->group(function () {
        Route::get('/', function() {
            return view('manage-bank.index');
        })->name('bank.index');

        Route::get('/create', function() {
            return view('manage-bank.create');
        })->name('bank.create');

        Route::post('/store', function() {
            return redirect()->route('bank.index');
        })->name('bank.store');

        Route::get('/edit/{id}', function($id) {
            return view('manage-bank.edit');
        })->name('bank.edit');

        Route::put('/update/{id}', function($id) {
            return redirect()->route('bank.index');
        })->name('bank.update');

        Route::delete('/destroy/{id}', function($id) {
            return redirect()->route('bank.index');
        })->name('bank.destroy');
    });
});
