<?php

use Illuminate\Database\Seeder;

class ClientSubSectorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client_sub_sectors =
        [
            [
                'code'        => 'COZ',
                'description' => 'Cozinha'
            ],
            [
                'code'        => 'REC',
                'description' => 'Recepção'
            ]
        ];
    
        foreach ($client_sub_sectors as $client_sub_sector)
        {
            \App\Entities\Tenant\ClientSubSector::create($client_sub_sector);
        }
    }
}
