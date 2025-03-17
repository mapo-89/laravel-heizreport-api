<?php

namespace Mapo89\LaravelHeizreportApi\Tests;

use Mapo89\LaravelHeizreportApi\HeizreportApiServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HeizreportApiServiceProvider::class,
        ];
    }
}
