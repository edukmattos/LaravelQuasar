<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BusinessTypeTableSeeder::class);
        $this->call(ClientTypeTableSeeder::class);
        $this->call(ClientStatusTableSeeder::class);
        $this->call(ClientLocationTypeTableSeeder::class);
    }
}
