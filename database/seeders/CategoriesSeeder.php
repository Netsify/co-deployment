<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 * Класс для заполнения категорий начальными данными
 *
 * Class CategoriesSeeder
 * @package Database\Seeders
 */
class CategoriesSeeder extends Seeder
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
                'slug' => "legislative_acts",
                'ru'   => ['name' => "Legislative acts"],
                'en'   => ['name' => "Законодательные акты"]
            ],
            [
                'slug' => "methodology_and_research",
                'ru'   => ['name' => "Methodology and research"],
                'en'   => ['name' => "Методология и исследования"]
            ],
            [
                'slug' => "training_materials",
                'ru'   => ['name' => "Training materials"],
                'en'   => ['name' => "Учебные материалы"]
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
