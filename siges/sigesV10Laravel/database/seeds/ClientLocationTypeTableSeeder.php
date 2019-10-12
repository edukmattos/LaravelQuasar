<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Entities\ClientLocationType;

class ClientLocationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_location_types =
        [
            [
                'code'        => 'Casa',
                'description' => 'Casa',
                'icon_name'   => 'home',
                'icon_color'  => 'primary'
            ],
            [
                'code'        => 'Trab',
                'description' => 'Trabalho',
                'icon_name'   => 'work',
                'icon_color'  => 'primary'
            ]
        ];
    
        foreach ($client_location_types as $client_location_type)
        {
            ClientLocationType::create($client_location_type);
        }
    }
}

