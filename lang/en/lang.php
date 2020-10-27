<?php return [
    'plugin' => [
        'name' => 'Tenancy',
        'description' => 'Manage multi tenant domains and subdomains from a single installation of October CMS',
        'access_denied' => 'You don\'t have enough permission',
    ],
    'models' => [
        'tenant' => [
            'active' => 'Active?',
            'host' => 'Tenant Domain/Subdomain',
            'host_comment' => 'like: domain.tld OR sbd.domain.tld',
            'theme' => 'Active Theme',
            'theme_comment' => 'Active theme for this tenant',
            'language' => 'Default Language',
            'language_comment' => 'Default language for this tenant',
            'usergroup' => 'Backend User Group',
            'usergroup_comment' => 'Permitted backend user group for this tenant',

            'on' => 'Yes',
            'off' => 'No',
        ],
    ],
    'controllers' => [
        'tenants' => [
            'title' => 'Tenant',
            'title_plural' => 'Tenants',

            'rebuild_cache' => 'Rebuild Tenant Cache',
            'rebuild_processing' => 'Rebuilding..',
            'rebuild_success' => 'Rebuilt successful',
        ],
    ],
];
