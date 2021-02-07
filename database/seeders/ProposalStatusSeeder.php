<?php

namespace Database\Seeders;

use App\Models\Facilities\ProposalStatus;
use Illuminate\Database\Seeder;

class ProposalStatusSeeder extends Seeder
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
                'slug'  => 'under_consideration',
                'ru'    => ['name' => "На рассмотрении"],
                'en'    => ['name' => "Under Consideration"],
            ],
            [
                'slug' => 'accepted',
                'ru'   => ['name' => "Принято"],
                'en'   => ['name' => "Accepted"],
            ],
            [
                'slug' => 'declined',
                'ru'   => ['name' => "Отклонено"],
                'en'   => ['name' => "Declined"],
            ],
        ];

        foreach ($statuses as $status) {
            ProposalStatus::create($status);
        }
    }
}
