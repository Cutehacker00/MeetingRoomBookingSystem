<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'MasterAdmin',
            ],
            [
                'id'    => 2,
                'title' => 'Admin',
            ],
            [
                'id'    => 3,
                'title' => 'User',
            ],
        ];

        Role::insert($roles);

    }
}
