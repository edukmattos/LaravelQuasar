<?php

namespace App\Http\Middleware\Tenant;

use App\Entities\Company;
use App\Events\Tenant\TenantIdentified;
use Closure;

class SetTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        #dd($next);
        #dd(session('tenant'));
        $tenant = $this->resolveTenant(session('tenant'));

        #dd($tenant);

        if (!$tenant) {
            return $next($request);
        }

        if (!auth()->user()->companies->contains('id', $tenant->id)) {
            return redirect('/home');
        }

        #dd($next($request));
        
        event(new TenantIdentified($tenant));
        
        return $next($request);
    }

    protected function resolveTenant($uuid)
    {
        return Company::where('uuid', $uuid)->first();
    }
}
