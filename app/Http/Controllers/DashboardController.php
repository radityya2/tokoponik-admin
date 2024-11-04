<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Blog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalBlogs = Blog::count();

        // Format angka dengan titik ribuan jika diperlukan
        $formattedUsers = number_format($totalUsers, 0, ',', '.');
        $formattedProducts = number_format($totalProducts, 0, ',', '.');
        $formattedBlogs = number_format($totalBlogs, 0, ',', '.');

        return view('dashboard', [
            'totalViews' => '3.456', // Ini bisa disesuaikan jika ada sistem view counter
            'totalProducts' => $formattedProducts,
            'totalUsers' => $formattedUsers,
            'totalBlogs' => $formattedBlogs
        ]);
    }
}
