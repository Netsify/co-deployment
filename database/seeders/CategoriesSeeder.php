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
                'en'   => ['name' => "Legislative acts"],
                'ru'   => ['name' => "Законодательные акты"]
            ],
            [
                'slug' => "methodology_and_research",
                'en'   => ['name' => "Methodology and research"],
                'ru'   => ['name' => "Методология и исследования"]
            ],
            [
                'slug' => "training_materials",
                'en'   => ['name' => "Training materials"],
                'ru'   => ['name' => "Учебные материалы"]
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
