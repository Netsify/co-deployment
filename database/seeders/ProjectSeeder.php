<?php

namespace Database\Seeders;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectFactory::new()->count(50)->create();
    }
}
