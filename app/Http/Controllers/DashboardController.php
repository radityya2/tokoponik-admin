<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Blog;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalBlogs = Blog::count();
        $totalTransactions = Transaction::count();


        return view('dashboard', compact('totalUsers', 'totalProducts', 'totalBlogs', 'totalTransactions'));
    }
}
