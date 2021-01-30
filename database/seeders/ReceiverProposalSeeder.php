<?php

namespace Database\Seeders;

use App\Models\Facilities\Proposal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiverProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 5; $i++) {
            DB::table('proposal_receiver')->insert(
                [
                    'proposal_id' => 1 /*Proposal::all()->random()->id*/,
                    'receiver_id' => User::all()->random()->id,
                ]
            );
        }
    }
}
