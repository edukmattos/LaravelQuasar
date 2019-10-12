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
        $this->call(ClientSectorTableSeeder::class);
        $this->call(ClientSubSectorTableSeeder::class);
        $this->call(MaterialUnitTableSeeder::class);
        #$this->call(UsersTableSeeder::class);
        #$this->call(MessagesTableSeeder::class);
        #$this->call(NotificationsTableSeeder::class);
    }
}
