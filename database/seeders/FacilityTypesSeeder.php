<?php

namespace Database\Seeders;

use App\Models\Facilities\FacilityType;
use Illuminate\Database\Seeder;

class FacilityTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'slug' => "road",
                'en'   => ['name' => "Road"],
                'ru'   => ['name' => "Дорога"]
            ],
            [
                'slug' => "ict",
                'en'   => ['name' => "ICT"],
                'ru'   => ['name' => "ИКТ"]
            ],
            [
                'slug' => "electricity",
                'en'   => ['name' => "Electricity"],
                'ru'   => ['name' => "Электричество"]
            ],
            [
                'slug' => "railway",
                'en'   => ['name' => "Railway"],
                'ru'   => ['name' => "Железная дорога"]
            ],
            [
                'slug' => "other",
                'en'   => ['name' => "Other"],
                'ru'   => ['name' => "Другое"]
            ],

        ];

        foreach ($types as $type) {
            FacilityType::create($type);
        }
    }
}
