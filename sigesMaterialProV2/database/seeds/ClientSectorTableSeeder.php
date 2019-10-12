<?php

use Illuminate\Database\Seeder;

class ClientSectorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_sectors =
        [
            [
                'code'        => 'TES',
                'description' => 'TESOURARIA'
            ],
            [
                'code'        => 'ADM',
                'description' => 'ADMINISTRATIVO'
            ]
        ];
    
        foreach ($client_sectors as $client_sector)
        {
            \App\Entities\Tenant\ClientSector::create($client_sector);
        }
    }
}
