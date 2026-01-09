<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            [
                'name' => 'Products',
                'count' => \App\Models\Product::count(),
                'description' => 'Total products available',
                'color'=>'blue-500',
                'icon'=>'box',
            ],
            [
                'name'=>'Product Clicks',
                'count' => 1323,
                'description' => 'Total product clicks',
                'color'=>'green-500',
                'icon'=>'web_traffic',
            ],
            [
                'name' => 'Categories',
                'count' => \App\Models\ProductCategory::count(),
                'description' => 'Total product categories',
                'color'=>'yellow-500',
                'icon'=>'category',
            ],
            [
                'name' => 'Users',
                'count' => \App\Models\User::count(),
                'description' => 'Total registered users',
                'color'=>'gray-500',
                'icon'=>'group',
            ],
        ];

        // Example transaction data for the last 7 days
        $transactionChart = [
            'labels' => [
                now()->subDays(6)->format('d-M'),
                now()->subDays(5)->format('d-M'),
                now()->subDays(4)->format('d-M'),
                now()->subDays(3)->format('d-M'),
                now()->subDays(2)->format('d-M'),
                now()->subDays(1)->format('d-M'),
                now()->format('d-M'),
            ],
            'data' => [12, 19, 7, 15, 10, 22, 17], // Example transaction count
            'nominal' => [
                1200000, 2100000, 900000, 1750000, 1100000, 2500000, 1800000
            ], // Example nominal in rupiah
        ];

        $latestTransactionOnTable = [
            [
                'id' => 'TXN001',
                'user' => 'Alice Johnson',
                'date' => '2024-06-20',
                'amount' => 250000,
                'status' => 'Completed',
            ],
            [
                'id' => 'TXN002',
                'user' => 'Bob Smith',
                'date' => '2024-06-19',
                'amount' => 150000,
                'status' => 'Pending',
            ],
            [
                'id' => 'TXN003',
                'user' => 'Charlie Brown',
                'date' => '2024-06-18',
                'amount' => 300000,
                'status' => 'Completed',
            ],
            [
                'id' => 'TXN004',
                'user' => 'Diana Prince',
                'date' => '2024-06-17',
                'amount' => 500000,
                'status' => 'Cancelled',
            ],
            [
                'id' => 'TXN005',
                'user' => 'Ethan Hunt',
                'date' => '2024-06-16',
                'amount' => 400000,
                'status' => 'Completed',
            ],
        ];

        return view('admin.dashboard', compact('data', 'transactionChart', 'latestTransactionOnTable'));
    }
}
