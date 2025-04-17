<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['name' => 'Not Purchased', 'slug' => 'not_purchased', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'In Wishlist', 'slug' => 'in_wishlist', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Purchased', 'slug' => 'purchased', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ready to Use', 'slug' => 'ready_to_use', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'In Use', 'slug' => 'in_use', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Damaged', 'slug' => 'damaged', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lost', 'slug' => 'lost', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Need Replacement', 'slug' => 'need_replacement', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
