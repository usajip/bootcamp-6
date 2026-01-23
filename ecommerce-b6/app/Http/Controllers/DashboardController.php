<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $summary = [
            [
                'name' => 'Products',
                'count' => Product::count(),
                'description' => 'Total products available',
                'color'=>'blue-500',
                'icon'=>'box',
            ],
            [
                'name'=>'Product Clicks',
                'count' => Product::sum('click'),
                'description' => 'Total product clicks',
                'color'=>'green-500',
                'icon'=>'web_traffic',
            ],
            [
                'name' => 'Categories',
                'count' => ProductCategory::count(),
                'description' => 'Total product categories',
                'color'=>'yellow-500',
                'icon'=>'category',
            ],
            [
                'name' => 'Users',
                'count' => User::count(),
                'description' => 'Total registered users',
                'color'=>'gray-500',
                'icon'=>'group',
            ],
        ];

        // Dynamic transaction data for the last 7 days
        $labels = [];
        $data = [];
        $nominal = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('d-M');
            $count = Transaction::whereDate('created_at', $date->toDateString())->count();
            $sum = Transaction::whereDate('created_at', $date->toDateString())->sum('total_amount');
            $data[] = $count;
            $nominal[] = $sum;
        }
        
        $transactionChart = [
            'labels' => $labels,
            'data' => $data,
            'nominal' => $nominal,
        ];

        $transactionList = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('summary', 'transactionChart', 'transactionList'));
    }
}
