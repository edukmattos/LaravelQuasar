<?php

namespace App\Http\Controllers\Api\V1;

use App\Entities\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    public function switch(Company $company)
    {
        session()->put('tenant', $company->uuid);

        return redirect('/home');
    }

    public function exit()
    {
        session()->flush('tenant');

        return redirect('/home');
    }
}
