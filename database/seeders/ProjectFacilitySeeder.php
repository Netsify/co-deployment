<?php

namespace Database\Seeders;

use App\Models\Facilities\Facility;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('project_facility')->insert(
                [
                    'project_id' => 1 /*Project::all()->random()->id*/,
                    'facility_id' => Facility::all()->random()->id,
                ]
            );
        }
    }
}
