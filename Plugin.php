<?php namespace Mahony0\Tenancy;

use Backend;
use BackendAuth;
use Cache;
use Mahony0\Tenancy\Models\Tenant;
use Event;
use Flash;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Translate'];

    public $elevated = true;

    public function pluginDetails()
    {
        return [
            'name'        => trans('mahony0.tenancy::lang.plugin.name'),
            'description' => trans('mahony0.tenancy::lang.plugin.description'),
            'author'      => 'Mahony0',
            'icon'        => 'icon-cubes',
        ];
    }

    public function registerPermissions()
    {
        return [
            'mahony0.tenancy.manage' => [
                'tab'   => trans('mahony0.tenancy::lang.plugin.name'),
                'label' => trans('mahony0.tenancy::lang.plugin.description'),
            ],
        ];
    }

    public function registerComponents()
    {
    }

    public function registerNavigation()
    {
        return [
            'tenancy' => [
                'label'         => 'mahony0.tenancy::lang.plugin.name',
                'url'           => Backend::url('mahony0/tenancy/tenants'),
                'icon'          => 'icon-sitemap',
                'permissions'   => ['mahony0.tenancy.*'],
                'order'         => 500,
                'sideMenu'      => [
                    'tenants' => [
                        'label'         => 'mahony0.tenancy::lang.controllers.tenants.title_plural',
                        'icon'          => 'icon-list-ol',
                        'url'           => Backend::url('mahony0/tenancy/tenants'),
                        'permissions'   => ['mahony0.tenancy.manage']
                    ]
                ]
            ]
        ];
    }

    public function boot()
    {
        // current host (e.g. sbd.domain.tld)
        $currentHostUrl = request()->getHost();

        /*
         * Restrict access to the site to super users and users belonging to a group with the same name as the domain
         */
        Event::listen('backend.user.login', function($backendUser) use ($currentHostUrl) {
            $logout = true;

            // if any of user's groups matches with tenant, allow backend
            $userGroupIds = $backendUser->groups()->pluck('id');
            if (
                $userGroupIds &&
                ($tenant = Tenant::where('host', $currentHostUrl)->whereIn('usergroup_id', $userGroupIds)->first())
            ) {
                $logout = false;
            }

            // always allow super users
            if ($backendUser->is_superuser === 1) {
                $logout = false;
            }

            // Logout
            if ($logout) {
                session(['tenancyLogout' => true]);
            }
        });

        /*
         *
         */
        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            if ($logout = session()->pull('tenancyLogout')) {
                BackendAuth::logout();
                Flash::error(trans('mahony0.tenancy::lang.plugin.access_denied'));
                return redirect(Backend::url('/'));
            }
        });

        /*
         * Listen for CMS activeTheme event, change theme according to config
         * If there's no match, let CMS set active theme
         */
        Event::listen('cms.theme.getActiveTheme', function() use ($currentHostUrl) {
            // all theme folders
            $themes = glob('themes/*', GLOB_ONLYDIR);

            // all tenants in cache
            foreach (Cache::get('tenants', []) as $tenant) {
                // if theme folder exists
                if ($tenant->host == $currentHostUrl && in_array('themes/'.$tenant->theme, $themes)) {
                    session(['tenancyHost' => $currentHostUrl]);
                    session(['tenancyLang' => $tenant->language]);

                    return $tenant->theme;
                }
            }
        });
    }
}
