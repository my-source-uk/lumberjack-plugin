<?php

return [
    'siteId' => 'ABCDEF',

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
];
