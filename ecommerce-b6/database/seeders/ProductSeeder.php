<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ProductCategory::insert([
            [
                'name' => 'Electronics',
                'description' => 'Devices and gadgets for daily use.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books',
                'description' => 'Wide range of books and literature.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel for men, women, and children.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Home Appliances',
                'description' => 'Appliances and tools for your home.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sports',
                'description' => 'Sports equipment and accessories.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $products = [];
        for ($i = 1; $i <= 30; $i++) {
            $categoryId = ($i % 5) + 1;
            $products[] = [
                'name' => "Product $i",
                'description' => "Description for product $i.",
                'price' => rand(10000, 100000),
                'stock' => rand(10, 100),
                'image_url' => "products/product.jpg",
                'product_category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        \App\Models\Product::insert($products);
    }
}
