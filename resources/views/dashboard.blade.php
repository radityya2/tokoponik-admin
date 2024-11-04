@extends('layout')

@section('title')
    Dashboard
@endsection

@section('content')
<div class="flex gap-6">
    <!-- Total Products -->
    <div class="bg-white rounded-lg p-6 w-64">
        <div class="flex flex-col">
            <div class="mb-4">
                <div class="bg-indigo-50 w-10 h-10 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="green" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</span>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-gray-500 text-sm">Total Products</span>

                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-lg p-6 w-64">
        <div class="flex flex-col">
            <div class="mb-4">
                <div class="bg-indigo-50 w-10 h-10 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="green" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</span>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-gray-500 text-sm">Total Users</span>

                </div>
            </div>
        </div>
    </div>

    <!-- Total Blogs -->
    <div class="bg-white rounded-lg p-6 w-64">
        <div class="flex flex-col">
            <div class="mb-4">
                <div class="bg-indigo-50 w-10 h-10 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="green" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-bold text-gray-900">{{ number_format($totalBlogs) }}</span>
                <div class="flex items-center justify-between mt-1">
                    <span class="text-gray-500 text-sm">Total Blogs</span>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
