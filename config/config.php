<?php

return [
    'siteId' => env('LUMBERJACK_SITE_ID'),

    'middelwaregroups' => ['web'],

    'models' => [
        'site' => Lumberjack\Models\Site::class,
        'visitor' => Lumberjack\Models\Visitor::class,
        'request' => Lumberjack\Models\Request::class,
        'page' => Lumberjack\Models\Page::class,
        'referrer' => Lumberjack\Models\Referrer::class,
        'browser' => Lumberjack\Models\Browser::class,
        'device' => Lumberjack\Models\Device::class,
    ],

    'table_names' => [
        'sites' => 'sites',
        'visitors' => 'visitors',
        'requests' => 'requests',
        'page_stats' => 'page_stats',
        'referrer_stats' => 'referrer_stats',
        'browser_stats' => 'browser_stats',
        'device_stats' => 'device_stats',
    ],

    'database' => [
        'connections' => [
            'lumberjack' => [
                'driver' => 'mysql',
                'url' => env('LUMBERJACK_DATABASE_URL'),
                'host' => env('LUMBERJACK_DB_HOST', '127.0.0.1'),
                'port' => env('LUMBERJACK_DB_PORT', '3306'),
                'database' => env('LUMBERJACK_DB_DATABASE', 'forge'),
                'username' => env('LUMBERJACK_DB_USERNAME', 'forge'),
                'password' => env('LUMBERJACK_DB_PASSWORD', ''),
                'unix_socket' => env('LUMBERJACK_DB_SOCKET', ''),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'prefix_indexes' => true,
                'strict' => true,
                'engine' => null,
                'options' => (true === extension_loaded('pdo_mysql')) ? array_filter(
                    [
                    PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
                    ]
                ) : [],
            ]
        ]
    ]
];
