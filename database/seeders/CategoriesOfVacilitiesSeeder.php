<?php

namespace Database\Seeders;

use App\Models\Variables\Category;
use Illuminate\Database\Seeder;

class CategoriesOfVacilitiesSeeder extends Seeder
{
    protected $categories = [
        ['slug' => "design", 'name_ru' => "Проектирование", 'name_en' => "Design"],
        ['slug' => "permits", 'name_ru' => "Получение разрешительных документов", 'name_en' => "Permits"],
        ['slug' => "direct", 'name_ru' => "Прямые материальные затраты", 'name_en' => "Direct material costs"],
        ['slug' => "indirect", 'name_ru' => "Непрямые материальные затраты", 'name_en' => "Indirect material costs"],
        ['slug' => "labor", 'name_ru' => "Фонд оплаты труда персонала", 'name_en' => "Labor payment"],
        ['slug' => "general", 'name_ru' => "Общие", 'name_en' => "General"],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category) {
            Category::create($category);
        }
    }
}
