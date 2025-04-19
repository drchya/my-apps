<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Clothing',               // id = 1
            'Shelter / Sleeping',     // id = 2
            'Cooking Gear',           // id = 3
            'Carrying Gear',          // id = 4
            'Lighting & Electronics', // id = 5
            'Navigation',             // id = 6
            'Survival Gear',          // id = 7
            'Water / Hydration',      // id = 8
            'First Aid',              // id = 9
            'Other'                   // id = 10
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
