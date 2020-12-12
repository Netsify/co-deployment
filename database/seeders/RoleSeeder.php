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
                'name' => Role::ROLE_ADMIN_EN,
                'slug' => 'admin'
            ]);

        Role::create([
                'name' => Role::ROLE_INFRASTRUCTURE_OWNER_EN,
                'slug' => 'owner'
            ]);

        Role::create([
                'name' => Role::ROLE_ICT_OPERATOR_OR_PROVIDER_EN,
                'slug' => 'ict'
            ]);

        Role::create([
                'name' => Role::ROLE_CONTRIBUTOR_EN,
                'slug' => 'contributor'
            ]);
    }
}
