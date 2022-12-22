<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => '1',
                'title' => 'user_management_access',
            ],
            [
                'id'    => '2',
                'title' => 'permission_access',
            ],
            [
                'id'    => '3',
                'title' => 'role_create',
            ],
            [
                'id'    => '4',
                'title' => 'role_edit',
            ],
            [
                'id'    => '5',
                'title' => 'role_show',
            ],
            [
                'id'    => '6',
                'title' => 'role_delete',
            ],
            [
                'id'    => '7',
                'title' => 'role_access',
            ],
            [
                'id'    => '8',
                'title' => 'user_create',
            ],
            [
                'id'    => '9',
                'title' => 'user_edit',
            ],
            [
                'id'    => '10',
                'title' => 'user_show',
            ],
            [
                'id'    => '11',
                'title' => 'user_delete',
            ],
            [
                'id'    => '12',
                'title' => 'user_access',
            ],
            [
                'id'    => '13',
                'title' => 'room_create',
            ],
            [
                'id'    => '14',
                'title' => 'room_edit',
            ],
            [
                'id'    => '15',
                'title' => 'room_show',
            ],
            [
                'id'    => '16',
                'title' => 'room_delete',
            ],
            [
                'id'    => '17',
                'title' => 'room_access',
            ],
            [
                'id'    => '18',
                'title' => 'event_create',
            ],
            [
                'id'    => '19',
                'title' => 'event_edit',
            ],
            [
                'id'    => '20',
                'title' => 'event_show',
            ],
            [
                'id'    => '21',
                'title' => 'event_delete',
            ],
            [
                'id'    => '22',
                'title' => 'event_access',
            ],
            [
                'id'    => '23',
                'title' => 'booking_create',
            ],
            [
                'id'    => '24',
                'title' => 'booking_edit',
            ],
            [
                'id'    => '25',
                'title' => 'booking_show',
            ],
            [
                'id'    => '26',
                'title' => 'booking_delete',
            ],
            [
                'id'    => '27',
                'title' => 'booking_access',
            ],
        ];

        Permission::insert($permissions);

    }
}
