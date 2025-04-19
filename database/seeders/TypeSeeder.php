<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Baselayer', 'category_id' => 1],
            ['name' => 'Midlayer', 'category_id' => 1],
            ['name' => 'Outer Layer', 'category_id' => 1],
            ['name' => 'Celana Outdoor', 'category_id' => 1],
            ['name' => 'Sarung Tangan', 'category_id' => 1],
            ['name' => 'Kaos Kaki', 'category_id' => 1],
            ['name' => 'Topi / Beanie', 'category_id' => 1],
            ['name' => 'Buff', 'category_id' => 1],
            ['name' => 'Sepatu', 'category_id' => 1],

            ['name' => 'Sleeping Bag', 'category_id' => 2],
            ['name' => 'Matras', 'category_id' => 2],
            ['name' => 'Tenda', 'category_id' => 2],
            ['name' => 'Flysheet', 'category_id' => 2],
            ['name' => 'Footprint', 'category_id' => 2],

            ['name' => 'Kompor', 'category_id' => 3],
            ['name' => 'Gas', 'category_id' => 3],
            ['name' => 'Cooking Set / Nesting', 'category_id' => 3],

            ['name' => 'Carrier', 'category_id' => 4],
            ['name' => 'Daypack', 'category_id' => 4],
            ['name' => 'Hydropack', 'category_id' => 4],
            ['name' => 'Rain Cover', 'category_id' => 4],
            ['name' => 'Dry Bag / Dry Sack', 'category_id' => 4],

            ['name' => 'Headlamp', 'category_id' => 5],
            ['name' => 'Senter', 'category_id' => 5],
            ['name' => 'Powerbank', 'category_id' => 5],

            ['name' => 'Kompas', 'category_id' => 6],

            ['name' => 'Tali', 'category_id' => 7],
            ['name' => 'Trekking Pole', 'category_id' => 7],
            ['name' => 'Pisau', 'category_id' => 7],
            ['name' => 'Trash Bag', 'category_id' => 7],
            ['name' => 'Gaiter', 'category_id' => 7],
            ['name' => 'Jas Hujan / Ponco', 'category_id' => 7],

            ['name' => 'Tumbler', 'category_id' => 8],
            ['name' => 'Water Bladder', 'category_id' => 8],

            ['name' => 'P3K', 'category_id' => 9],
        ];

        foreach ($types as $type) {
            DB::table('types')->insert([
                'name' => $type['name'],
                'category_id' => $type['category_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
