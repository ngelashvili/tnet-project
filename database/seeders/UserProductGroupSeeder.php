<?php

namespace Database\Seeders;

use App\Models\UserProductGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserProductGroup::insert([
            'user_id' => 5,
            'discount' => 15
        ]);
    }
}
