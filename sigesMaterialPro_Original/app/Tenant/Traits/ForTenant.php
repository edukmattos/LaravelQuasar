<?php

namespace App\Tenant\Traits;

trait ForTenant
{
    public function getConnectionName()
    {
        return 'tenant';
    }
}