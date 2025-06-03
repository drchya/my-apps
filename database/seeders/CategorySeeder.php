<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Clothing',
            'Shelter / Sleeping',
            'Cooking Gear',
            'Carrying Gear',
            'Lighting & Electronics',
            'Navigation',
            'Survival Gear',
            'Water / Hydration',
            'First Aid',
            'Other'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'slug' => Str::slug($category),
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
