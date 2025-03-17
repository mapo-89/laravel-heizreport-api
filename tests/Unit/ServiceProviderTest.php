<?php

namespace Mapo89\LaravelHeizreportApi\Tests\Unit;

use Mapo89\LaravelHeizreportApi\Tests\TestCase;

class ServiceProviderTest extends TestCase
{
    public function test_publish_config()
    {
        $this->artisan('vendor:publish', [
            '--provider' => 'Mapo89\LaravelHeizreportApi\HeizreportApiServiceProvider',
            '--tag'=>'config'
        ]);

        $this->assertFileExists(config_path('heizreport-api.php'));
        $this->assertFileIsReadable(config_path('heizreport-api.php'));
        $this->assertFileEquals(config_path('heizreport-api.php'), __DIR__ . '/../../config/config.php');
        $this->assertTrue(unlink(config_path('heizreport-api.php')));
    }
}
