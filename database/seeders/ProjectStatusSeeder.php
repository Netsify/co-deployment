<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'slug'  => 'in_progress',
                'ru'    => ['name' => "В работе"],
                'en'    => ['name' => "In progress"],
            ],
            [
                'slug' => 'completed',
                'ru'   => ['name' => "Завершён"],
                'en'   => ['name' => "Completed"],
            ],
            [
                'slug' => 'cancelled',
                'ru'   => ['name' => "Отменён"],
                'en'   => ['name' => "Cancelled"],
            ],
        ];

        foreach ($statuses as $status) {
            ProjectStatus::create($status);
        }
    }
}
