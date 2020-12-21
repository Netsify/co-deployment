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
        $roles = [
            [
                'slug' => Role::ROLE_ADMIN,
                'ru' => ['name' => 'Администратор'],
                'en' => ['name' => 'Administrator']
            ],
            [
                'slug' => Role::ROLE_ROADS_OWNER,
                'ru' => ['name' => 'Владелец дорожно-транспортной или энергетической инфраструктуры'],
                'en' => ['name' => 'Infrastructure owner']
            ],
            [
                'slug' => Role::ROLE_ICT_OWNER,
                'ru' => ['name' => 'Владелец инфраструктуры ИКТ'],
                'en' => ['name' => 'ICT operator or provider']
            ],
            [
                'slug' => Role::ROLE_CONTRIBUTOR,
                'ru' => ['name' => 'Участник'],
                'en' => ['name' => 'Contributor']
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
