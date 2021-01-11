<?php

namespace Database\Seeders;

use App\Models\Facilities\FacilityVisibility;
use Illuminate\Database\Seeder;

class FacilityVisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visibilities = [
            [
                'slug' => "only_for_me",
                'ru'   => ['name' => "Только для меня"],
                'en'   => ['name' => "Only for me"],
            ],
            [
                'slug' => "for_registered",
                'ru'   => ['name' => "Для зарегистрированных"],
                'en'   => ['name' => "For registered"],
            ],
            [
                'slug' => "for_all",
                'ru'   => ['name' => "Для всех"],
                'en'   => ['name' => "For all"],
            ],
        ];

        foreach ($visibilities as $visibility) {
            FacilityVisibility::create($visibility);
        }
    }
}
