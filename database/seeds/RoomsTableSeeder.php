<?php

use App\Room;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            [
                'id'             => 1,
                'name'           => 'BD Room',
                'capacity'       => '7',
                'description'    => 'HDMI Connector, TV, Whiteboard',
                
            ],
            [
                'id'             => 2,
                'name'           => 'Boardroom',
                'capacity'       => '15',
                'description'    => 'HDMI Connector, Bluetooth Driver, TV, Whiteboard Stand, Plugs',
                
            ],
            [
                'id'             => 3,
                'name'           => 'Small Room 1',
                'capacity'       => '5',
                'description'    => 'HDMI Connector, TV',
                
            ],
            [
                'id'             => 4,
                'name'           => 'Small Room 2',
                'capacity'       => '5',
                'description'    => 'HDMI Connector, TV',
                
            ],
        ];

        Room::insert($rooms);
    }
}
