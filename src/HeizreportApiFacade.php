<?php

namespace Mapo89\HeizreportApi;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mapo89\HeizreportApi\Skeleton\SkeletonClass
 */
class HeizreportApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'heizreportapi';
    }
}
