<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('project_user')->insert(
                [
                    'project_id' => Project::all()->random()->id,
                    'user_id' => 1 /*User::all()->random()->id*/,
                ]
            );
        }
    }
}
