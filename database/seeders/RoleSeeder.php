<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Administrator',
            'slug' => Role::ROLE_ADMIN
        ]);

        Role::create([
            'name' => 'Infrastructure owner',
            'slug' => Role::ROLE_INFRASTRUCTURE_OWNER
        ]);

        Role::create([
            'name' => 'ICT operator or provider',
            'slug' => Role::ROLE_ICT_OPERATOR_OR_PROVIDER
        ]);

        Role::create([
            'name' => 'Contributor',
            'slug' => Role::ROLE_CONTRIBUTOR
        ]);
    }
}
