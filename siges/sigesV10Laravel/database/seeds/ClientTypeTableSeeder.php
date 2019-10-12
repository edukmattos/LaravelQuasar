<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Entities\ClientType;

class ClientTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_types =
        [
            [
                'code'        => 'PF',
                'description' => 'P.Física'
            ],
            [
                'code'        => 'PJ',
                'description' => 'P.Jurídica'
            ]
        ];
    
        foreach ($client_types as $client_type)
        {
            ClientType::create($client_type);
        }
    }
}

