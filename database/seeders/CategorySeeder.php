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
            'Clothing',
            'First Aid',
            'Navigtaion',
            'Shelter / Sleeping',
            'Cooking Gear',
            'Carrying Gear',
            'Lighting & Electronics',
            'Survival Gear',
            'Water / Hydration',
            'Health & Fitness',
            'Other'
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
