@extends('layout')

@section('title')
    Dashboard
@endsection

@section('content')
<h1 class="text-2xl font-semibold mb-6">Dashboard</h1>
<div class="p-6">
    <!-- Stats Cards -->
    <div class="flex gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm">
            <div class="flex items-center justify-center h-full">
                <div class="bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mr-8">
                <svg width="32" height="24" viewBox="0 0 50 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.875 37.75C21.875 37.75 18.75 37.75 18.75 34.625C18.75 31.5 21.875 22.125 34.375 22.125C46.875 22.125 50 31.5 50 34.625C50 37.75 46.875 37.75 46.875 37.75H21.875Z" fill="#006838"/>
                    <path d="M34.375 19C39.5527 19 43.75 14.8027 43.75 9.625C43.75 4.44733 39.5527 0.25 34.375 0.25C29.1973 0.25 25 4.44733 25 9.625C25 14.8027 29.1973 19 34.375 19Z" fill="#006838"/>
                    <path d="M16.3011 37.75C15.8611 36.8622 15.625 35.8098 15.625 34.625C15.625 30.3892 17.747 26.033 21.6748 22.9999C19.9565 22.4503 17.9534 22.125 15.625 22.125C3.125 22.125 0 31.5 0 34.625C0 37.75 3.125 37.75 3.125 37.75H16.3011Z" fill="#006838"/>
                    <path d="M14.0625 19C18.3772 19 21.875 15.5022 21.875 11.1875C21.875 6.87278 18.3772 3.375 14.0625 3.375C9.74778 3.375 6.25 6.87278 6.25 11.1875C6.25 15.5022 9.74778 19 14.0625 19Z" fill="#006838"/>
                </svg>

                </div>
                <div class="text-left">
                    <span class="text-3xl font-bold text-gray-900" id="totalUsers">0</span>
                    <span class="block text-gray-500 text-sm">Total Users</span>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm">
            <div class="flex items-center justify-center h-full">
                <div class="bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mr-8">
                    <svg width="32" height="32" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M48.5267 9.2904C49.4165 9.64633 50 10.5081 50 11.4665V38.5337C50 39.492 49.4165 40.3538 48.5267 40.7098L25.8704 49.7723C25.3117 49.9958 24.6883 49.9958 24.1296 49.7723L1.4733 40.7098C0.58348 40.3538 0 39.492 0 38.5337V11.4665C0 10.5082 0.583479 9.64633 1.4733 9.2904L23.2591 0.575973C23.2687 0.572124 23.2784 0.568308 23.288 0.564525L24.1296 0.227905C24.6883 0.00439506 25.3117 0.00439422 25.8704 0.227905L26.7121 0.564558C26.7217 0.56833 26.7313 0.572135 26.7409 0.575973L48.5267 9.2904ZM32.5115 6.25004L13.2813 13.9421L5.76977 10.9375L3.125 11.9955V13.2454L23.4375 21.3704V46.1297L25 46.7547L26.5625 46.1297V21.3704L46.875 13.2454V11.9955L44.2302 10.9375L25 18.6296L17.4884 15.625L36.7186 7.93291L32.5115 6.25004Z" fill="#006838"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-3xl font-bold text-gray-900" id="totalProducts">0</span>
                    <span class="block text-gray-500 text-sm">Total Products</span>
                </div>
            </div>
        </div>

        <!-- Total Blogs -->
        <div class="bg-white rounded-lg p-6 flex-1 shadow-sm">
            <div class="flex items-center justify-center h-full">
                <div class="bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mr-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#006838" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1z"/>
                </svg>

                </div>
                <div class="text-left">
                    <span class="text-3xl font-bold text-gray-900" id="totalBlogs">0</span>
                    <span class="block text-gray-500 text-sm">Total Blogs</span>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-white rounded-lg p-8 flex-1 shadow-sm">
            <div class="flex items-center justify-center h-full">
                <div class="bg-green-50 w-16 h-16 rounded-full flex items-center justify-center mr-8">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#006838" class="bi bi-bag-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <span class="text-3xl font-bold text-gray-900" id="totalTransactions">0</span>
                    <span class="block text-gray-500 text-sm">Total Transaction</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Graph -->
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <h2 class="text-lg font-semibold mb-6">Transaction overview</h2>
        <div class="h-[300px]" id="transactionChart"></div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Fungsi untuk memformat data transaksi per bulan
    function processTransactionData(transactions) {
        let monthlyData = new Array(12).fill(0);

        transactions.forEach(transaction => {
            const date = new Date(transaction.created_at);
            const month = date.getMonth(); // 0-11
            monthlyData[month] += parseFloat(transaction.grand_total);
        });

        return monthlyData;
    }

    // Konfigurasi grafik
    var options = {
        series: [{
            name: 'Total Transaksi',
            data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0] // Default values
        }],
        chart: {
            height: 300,
            type: 'line',
            toolbar: {
                show: false
            },
            locales: [{
                name: 'id',
                options: {
                    months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                }
            }],
            defaultLocale: 'id'
        },
        colors: ['#006838'],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        grid: {
            borderColor: '#E5E7EB',
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
        },
        yaxis: {
            min: 0,
            max: 10000000,
            tickAmount: 5, // Akan menghasilkan 6 titik (termasuk 0)
            labels: {
                formatter: function (value) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(value) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                }
            }
        }
    };

    // Inisialisasi grafik
    var chart = new ApexCharts(document.querySelector("#transactionChart"), options);
    chart.render();

    // Memuat data transaksi dari API
    $(document).ready(function() {
        const token = localStorage.getItem('token');

        $.ajax({
            url: 'http://127.0.0.1:8000/api/auth/transactions',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.data) {
                    const monthlyData = processTransactionData(response.data);
                    chart.updateSeries([{
                        name: 'Total Transaksi',
                        data: monthlyData
                    }]);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
            }
        });

        $.ajax({
        url: 'http://127.0.0.1:8000/api/auth/users',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            if (response.data) {
                $('#totalUsers').text(response.data.length);
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            $('#totalUsers').text('0');
        }
    });

    $.ajax({
        url: 'http://127.0.0.1:8000/api/products',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            console.log('Products response:', response);
            if (response.data) {
                $('#totalProducts').text(response.data.length);
            }
        },
        error: function(xhr) {
            console.error('Products error:', xhr);
            $('#totalProducts').text('0');
        }
    });

    $.ajax({
        url: 'http://127.0.0.1:8000/api/auth/blogs',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            if (response.data) {
                $('#totalBlogs').text(response.data.length);
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            $('#totalBlogs').text('0');
        }
    });

    $.ajax({
        url: 'http://127.0.0.1:8000/api/auth/transactions',
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            if (response.data) {
                $('#totalTransactions').text(response.data.length);
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            $('#totalTransactions').text('0');
        }
    });


    });
</script>
@endpush
@endsection
