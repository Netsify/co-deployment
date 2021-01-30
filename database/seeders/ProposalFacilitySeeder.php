<?php

namespace Database\Seeders;

use App\Models\Facilities\Facility;
use App\Models\Facilities\Proposal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProposalFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++) {
            DB::table('proposal_facility')->insert(
                [
                    'proposal_id' => 1 /*Proposal::all()->random()->id*/,
                    'facility_id' => Facility::all()->random()->id,
                ]
            );
        }
    }
}
