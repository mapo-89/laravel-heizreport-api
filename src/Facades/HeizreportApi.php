<?php
/*
 * HeizreportApi.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

 namespace Mapo89\LaravelHeizreportApi\Facades;

use Illuminate\Support\Facades\Facade;

class HeizreportApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'heizreport-api';
    }
}
