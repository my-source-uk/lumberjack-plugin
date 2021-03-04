<?php

namespace Lumberjack;

trait ServiceBindings
{
    /**
     * All of the service bindings for Horizon.
     *
     * @var array
     */
    public $serviceBindings = [
        // General services...
        // AutoScaler::class,
        // Contracts\HorizonCommandQueue::class => RedisHorizonCommandQueue::class,
        // Listeners\TrimRecentJobs::class,
        // Listeners\TrimFailedJobs::class,
        // Listeners\TrimMonitoredJobs::class,
        // Lock::class,
        // Stopwatch::class,

        // Repository services...
        Contracts\BaseRepository::class => Repositories\BaseRepository::class,
        Contracts\VisitorRepository::class => Repositories\VisitorRepository::class,
        Contracts\ReferrerRepository::class => Repositories\ReferrerRepository::class,
        Contracts\DeviceRepository::class => Repositories\DeviceRepository::class,
        Contracts\BrowserRepository::class => Repositories\BrowserRepository::class,
        Contracts\RequestRepository::class => Repositories\RequestRepository::class,
    ];
}
