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
            'Baselayer',
            'Midlayer',
            'Outer Layer',
            'Celana Outdoor',
            'Sarung Tangan',
            'Kaos Kaki',
            'Topi / Beanie',
            'Buff',
            'Sepatu',

            'Sleeping Bag',
            'Matras',

            'Tenda',
            'Flysheet',
            'Footprint',

            'Kompor',
            'Gas',
            'Cooking Set / Nesting',

            'Carrier',
            'Daypack',
            'Hydropack',
            'Rain Cover',
            'Dry Bag / Dry Sack',

            'Headlamp',
            'Senter',
            'Kompas',
            'Tali',
            'Trekking Pole',

            'Tumbler',
            'Water Bladder',
            'P3K',
            'Jas Hujan / Ponco',
            'Powerbank',
            'Trash Bag',
            'Gaiter',
            'Pisau',
        ];

        foreach ($types as $type) {
            DB::table('types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
