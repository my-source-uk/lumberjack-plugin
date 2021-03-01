<?php

namespace MySource\Lumberjack;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MySource\Lumberjack\Skeleton\SkeletonClass
 */
class LumberjackFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lumberjack';
    }
}
