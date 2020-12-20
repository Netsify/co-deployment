<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'tag' => "road",
                'en'   => ['name' => "Road"],
                'ru'   => ['name' => "Дорога"]
            ],
            [
                'tag' => "ict",
                'en'   => ['name' => "ICT"],
                'ru'   => ['name' => "ИКТ"]
            ],
            [
                'tag' => "electricity",
                'en'   => ['name' => "Electricity"],
                'ru'   => ['name' => "Электричество"]
            ],

        ];

        foreach ($categories as $category) {
            Tag::create($category);
        }
    }
}
