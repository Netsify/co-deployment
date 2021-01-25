<?php

namespace Database\Seeders;

use App\Models\Facilities\CompatibilityParamGroup;
use Illuminate\Database\Seeder;

class CompatibilityParamGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            [
                'slug' => "technical",
                'en'   => ['name' => "Technical parameters"],
                'ru'   => ['name' => "Технические параметры"]
            ],
            [
                'slug' => "organizational",
                'en'   => ['name' => "Organizational factors"],
                'ru'   => ['name' => "Организационные факторы"]
            ],
            [
                'slug' => "georgaphical",
                'en'   => ['name' => "Georgaphical factors"],
                'ru'   => ['name' => "Географические факторы"]
            ],
            [
                'slug' => "socio-economic",
                'en'   => ['name' => "Socio-economic factors"],
                'ru'   => ['name' => "Социально-экономические факторы"]
            ],
        ];

        foreach ($params as $param) {
            CompatibilityParamGroup::create($param);
        }
    }
}
