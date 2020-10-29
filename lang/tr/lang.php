<?php return [
    'plugin' => [
        'name' => 'Tenancy',
        'description' => 'Tek bir October CMS kurulumu ile birden fazla alan adlarını ve alt alan adlarını yönetin',
        'access_denied' => 'Panele erişebilmek için yeterli yetkiniz yok. Lütfen yöneticinizle iletişime geçin',
    ],
    'models' => [
        'tenant' => [
            'active' => 'Aktif?',
            'host' => 'Tenant Domain/Subdomain',
            'host_comment' => 'örnek: domain.tld VEYA sbd.domain.tld',
            'theme' => 'Aktif Tema',
            'theme_comment' => 'Bu domain için aktif tema',
            'language' => 'Öntanımlı Dil',
            'language_comment' => 'Bu domain için öntanımlı dil',
            'usergroup' => 'Backend User Group',
            'usergroup_comment' => 'Bu domain için giriş izni olan backend kullanıcılar',

            'on' => 'Evet',
            'off' => 'Hayır',
        ],
    ],
    'controllers' => [
        'tenants' => [
            'title' => 'Tenant',
            'title_plural' => 'Tenants',

            'rebuild_cache' => 'Tenant Önbelleğini Tekrar Oluştur',
            'rebuild_processing' => 'Oluşturuluyor..',
            'rebuild_success' => 'Önbellek oluşturuldu',
        ],
    ],
];
