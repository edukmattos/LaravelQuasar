<?php

namespace App\Tenant\Database;

use App\Tenant\Models\Tenant;
use Illuminate\Database\DatabaseManager as BaseDatabaseManager;

class DatabaseManager
{
    protected $db;

    public function __construct(BaseDatabaseManager $db)
    {
        $this->db = $db;
    }

    public function createConnection(Tenant $tenant) 
    {
        #dd($this->getTenantConnection($tenant));
        config()->set('database.connections.tenant', $this->getTenantConnection($tenant));  
        #dd(config('database'));
    }

    protected function getTenantConnection(Tenant $tenant)
    {
        #dd($this->getDefaultConnectionName());
        
        return array_merge(
            config()->get($this->getConfigConnectionPath()), $tenant->tenantConnection->only('database')
        );
    }

    public function connectToTenant()
    {
        #dd($this->db);
        $this->db->reconnect('tenant');
    }

    public function purge()
    {
        $this->db->purge('tenant');
    }

    protected function getConfigConnectionPath() 
    {
        return sprintf('database.connections.%s', $this->getDefaultConnectionName());
    }

    protected function getDefaultConnectionName()
    {
        return config('database.default');
    }
}