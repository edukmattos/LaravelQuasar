<?php

namespace App\Console\Commands\Tenant;

use App\Entities\Company;
use Illuminate\Console\Command;
use App\Tenant\Database\DatabaseManager;
use App\Tenant\Traits\Console\FetchesTenant;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Console\Seeds\SeedCommand;
use App\Tenant\Traits\Console\AcceptsMultipleTenants;
use Illuminate\Database\ConnectionResolverInterface as Resolver;

class Seed extends SeedCommand
{
    use FetchesTenant, AcceptsMultipleTenants;
    
    protected $db;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    ##protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds tenants databases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Resolver $resolver, DatabaseManager $db)
    {
        parent::__construct($resolver);

        $this->setName('tenants:seed');

        $this->specifyParameters();

        $this->db = $db;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return;
        }

        $this->input->setOption('database', 'tenant');

        $this->tenants($this->option('tenants'))->each(function($tenant) {
            // cretae database connection
            $this->db->createConnection($tenant);
            #dd(config('database'));
            
            // connect to the tenant
            $this->db->connectToTenant();
            
            parent::handle();

            // purge
            $this->db->purge();
        });
    }  
}