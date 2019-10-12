<?php

namespace App\Tenant\Traits\Console;

use App\Entities\Company;

trait FetchesTenant
{
    public function tenants($ids = null)
    {
        $tenants = Company::query();

        if ($ids) {
            $tenants = $tenants->whereIn('id', $ids);
        }

        return $tenants;
    }
}