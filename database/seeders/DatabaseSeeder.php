<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Migration Seeders
         */
//        $this->call(RoleSeeder::class);
//        $this->call(CategoriesSeeder::class);
//        $this->call(CompatibilityParamGroupSeeder::class);
//        $this->call(FacilityTypesSeeder::class);
//        $this->call(FacilityVisibilitySeeder::class);
//        $this->call(TagsSeeder::class);
//        $this->call(CategoriesOfVariablesSeeder::class);

        /**
         * Actual Seeders
         */
        $this->call(ProposalStatusSeeder::class);
        $this->call(ProjectStatusSeeder::class);
        $this->call(GroupOfVariableSeeder::class);

        /*
         * Fake Seeders
         */
        $this->call(UserSeeder::class);
        $this->call(ProposalSeeder::class);
//        $this->call(FacilitySeeder::class);
        $this->call(FacilityProposalSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(FacilityProjectSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ProjectUserSeeder::class);
    }
}
