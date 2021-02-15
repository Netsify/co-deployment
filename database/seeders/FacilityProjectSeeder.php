<?php

namespace Database\Seeders;

use App\Models\Facilities\Facility;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilityProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('facility_project')->insert(
                [
                    'facility_id' => Facility::all()->random()->id,
                    'project_id' => 1 /*Project::all()->random()->id*/,
                ]
            );
        }
    }
}
