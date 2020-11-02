<?php namespace Mahony0\Tenancy\Classes;

use Cache;
use Mahony0\Tenancy\Models\Tenant;

class Helpers
{
    public function rebuildTenantCache()
    {
        Cache::forget('tenants');

        Cache::rememberForever('tenants', function() {
            return Tenant::isActive()->get()->toArray();
        });
    }
}
