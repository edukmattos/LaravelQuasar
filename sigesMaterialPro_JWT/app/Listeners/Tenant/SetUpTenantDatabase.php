<?php

namespace App\Listeners\Tenant;

use App\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Tenant\TenantDatabaseCreated;

class SetUpTenantDatabase
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TenantDatabaseCreated  $event
     * @return void
     */
    public function handle(TenantDatabaseCreated $event)
    {
        if ($this->migrate($event->tenant)) {
            $this->seed($event->tenant);
        }
    }

    protected function migrate(Tenant $tenant)
    {
        $migration = Artisan::call('tenants:migrate', [
            '--tenants' => [$tenant->id]
        ]);

        return $migration === 0;
    }

    protected function seed(Tenant $tenant)
    {
        return Artisan::call('tenants:seed', [
            '--tenants' => [$tenant->id]
        ]);
    }
}
