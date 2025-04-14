<?php

namespace Database\Seeders;

use App\Models\Mountain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MountainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mountains = [
            [
                'name' => 'Gunung Ciremai',
                'location' => 'West Java, Indonesia',
                'latitude' => -6.9311,
                'longitude' => 108.3682,
                'elevation' => 3078
            ],
            [
                'name' => 'Gunung Gede',
                'location' => 'West Java, Indonesia',
                'latitude' => -6.7433,
                'longitude' => 106.9633,
                'elevation' => 2958
            ],
            [
                'name' => 'Gunung Pangrango',
                'location' => 'West Java, Indonesia',
                'latitude' => -6.7089,
                'longitude' => 106.9683,
                'elevation' => 3019
            ],
            [
                'name' => 'Gunung Salak',
                'location' => 'West Java, Indonesia',
                'latitude' => -6.7171,
                'longitude' => 106.8074,
                'elevation' => 2211
            ],
            [
                'name' => 'Gunung Merbabu',
                'location' => 'Central Java, Indonesia',
                'latitude' => -7.5403,
                'longitude' => 110.4972,
                'elevation' => 3142
            ],
            [
                'name' => 'Gunung Slamet',
                'location' => 'Central Java, Indonesia',
                'latitude' => -7.4092,
                'longitude' => 109.2375,
                'elevation' => 3428
            ],
            [
                'name' => 'Gunung Sumbing',
                'location' => 'Central Java, Indonesia',
                'latitude' => -7.3083,
                'longitude' => 109.2236,
                'elevation' => 3371
            ],
            [
                'name' => 'Gunung Sindoro',
                'location' => 'Central Java, Indonesia',
                'latitude' => -7.2686,
                'longitude' => 109.2931,
                'elevation' => 3136
            ],
            [
                'name' => 'Gunung Merapi',
                'location' => 'Central Java, Indonesia',
                'latitude' => -7.5407,
                'longitude' => 110.4428,
                'elevation' => 2911
            ],
            [
                'name' => 'Gunung Kerinci',
                'location' => 'West Sumatra',
                'latitude' => -1.6978,
                'longitude' => 101.2642,
                'elevation' => 3805,
            ],
            [
                'name' => 'Gunung Rinjani',
                'location' => 'West Nusa Tenggara',
                'latitude' => -8.4149,
                'longitude' => 116.4602,
                'elevation' => 3726
            ],
        ];

        foreach ($mountains as $mountain) {
            Mountain::create($mountain);
        }
    }
}
