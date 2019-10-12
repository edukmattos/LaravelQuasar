<?php

namespace App\Tenant\Database;

use App\Tenant\Models\Tenant;
use DB;

class DatabaseCreator 
{
    public function create(Tenant $tenant)
    {
        return DB::statement("
            CREATE DATABASE ekmtek_siges_{$tenant->id}
        ");
    }
}