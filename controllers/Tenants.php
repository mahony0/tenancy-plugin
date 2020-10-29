<?php namespace Mahony0\Tenancy\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Cache;
use Flash;
use Mahony0\Tenancy\Models\Tenant;

class Tenants extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\FormController::class
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'mahony0.tenancy.manage'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Mahony0.Tenancy', 'tenancy', 'tenants');
    }

    public function onRebuildTenantCache()
    {
        Cache::rememberForever('tenants', function() {
            return Tenant::isActive()->get();
        });

        Flash::success(e(trans('mahony0.tenancy::lang.controllers.tenants.rebuild_success')));

        return $this->listRefresh();
    }
}
