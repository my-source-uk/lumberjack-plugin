<?php

return [
    'siteId' => 'ABCDEF',

    'models' => [
        'sites' => Lumberjack\Models\Site::class,
        'visitors' => Lumberjack\Models\Visitor::class,
        'requests' => Lumberjack\Models\Request::class,
        'page_stats' => Lumberjack\Models\Stats\Page::class,
        'referrer_stats' => Lumberjack\Models\Stats\Referrer::class,
        'browser_stats' => Lumberjack\Models\Stats\Browser::class,
        'device_stats' => Lumberjack\Models\Stats\Device::class,
    ],
];
