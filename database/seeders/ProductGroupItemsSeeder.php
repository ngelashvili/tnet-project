<?php

namespace Database\Seeders;

use App\Models\ProductGroupItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGroupItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductGroupItem::insert([
            [
                'group_id' => 1,
                'product_id' => 2,
            ],
            [
                'group_id' => 1,
                'product_id' => 5,
            ]
        ]);
    }
}
