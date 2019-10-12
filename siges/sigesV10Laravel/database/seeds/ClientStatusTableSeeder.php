<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Entities\ClientStatus;

class ClientStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_statuses =
        [
            [
                'code'        => 'AT',
                'description' => 'Ativo',
                'icon_name'   => 'check',
                'icon_color'  => 'green'
            ],
            [
                'code'        => 'IN',
                'description' => 'Inativo',
                'icon_name'   => 'clock',
                'icon_color'  => 'red'
            ]
        ];
    
        foreach ($client_statuses as $client_status)
        {
            ClientStatus::create($client_status);
        }
    }
}

