<?php

namespace Database\Seeders;

use App\Models\Mountain;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MountainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mountains = [
            [
                'name' => 'Ciremai',
                'slug' => Str::random(8),
                'location' => 'Kuningan, Jawa Barat, Indonesia',
                'latitude' => -6.9311,
                'longitude' => 108.3682,
                'elevation' => 3078
            ],
            [
                'name' => 'Gede',
                'slug' => Str::random(8),
                'location' => 'Cianjur, Jawa Barat, Indonesia',
                'latitude' => -6.7433,
                'longitude' => 106.9633,
                'elevation' => 2958
            ],
            [
                'name' => 'Pangrango',
                'slug' => Str::random(8),
                'location' => 'Sukabumi, Jawa Barat, Indonesia',
                'latitude' => -6.7089,
                'longitude' => 106.9683,
                'elevation' => 3019
            ],
            [
                'name' => 'Salak',
                'slug' => Str::random(8),
                'location' => 'Bogor, Jawa Barat, Indonesia',
                'latitude' => -6.7171,
                'longitude' => 106.8074,
                'elevation' => 2211
            ],
            [
                'name' => 'Merbabu',
                'slug' => Str::random(8),
                'location' => 'Magelang, Jawa Tengah, Indonesia',
                'latitude' => -7.5403,
                'longitude' => 110.4972,
                'elevation' => 3142
            ],
            [
                'name' => 'Slamet',
                'slug' => Str::random(8),
                'location' => 'Banyumas, Jawa Tengah, Indonesia',
                'latitude' => -7.4092,
                'longitude' => 109.2375,
                'elevation' => 3428
            ],
            [
                'name' => 'Sumbing',
                'slug' => Str::random(8),
                'location' => 'Temanggung, Jawa Tengah, Indonesia',
                'latitude' => -7.3083,
                'longitude' => 109.2236,
                'elevation' => 3371
            ],
            [
                'name' => 'Sindoro',
                'slug' => Str::random(8),
                'location' => 'Wonosobo, Jawa Tengah, Indonesia',
                'latitude' => -7.2686,
                'longitude' => 109.2931,
                'elevation' => 3136
            ],
            [
                'name' => 'Merapi',
                'slug' => Str::random(8),
                'location' => 'Sleman, DI Yogyakarta, Indonesia',
                'latitude' => -7.5407,
                'longitude' => 110.4428,
                'elevation' => 2911
            ],
            [
                'name' => 'Kerinci',
                'slug' => Str::random(8),
                'location' => 'Kerinci, Jambi, Indonesia',
                'latitude' => -1.6978,
                'longitude' => 101.2642,
                'elevation' => 3805,
            ],
            [
                'name' => 'Rinjani',
                'slug' => Str::random(8),
                'location' => 'Lombok Timur, Nusa Tenggara Barat, Indonesia',
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
