<?php

use Illuminate\Database\Seeder;
use App\Api\V1\Entities\BusinessType;

class BusinessTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $business_types =
        [
            [
                'code'        => 'COM',
                'description' => 'Comercio'
            ],
            [
                'code'        => 'SAN',
                'description' => 'Saneamento'
            ]
        ];
    
        foreach ($business_types as $business_type)
        {
            BusinessType::create($business_type);
        }
    }
}

