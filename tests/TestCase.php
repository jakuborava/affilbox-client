<?php

namespace JakubOrava\AffilboxClient\Tests;

use JakubOrava\AffilboxClient\AffilboxClientServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            AffilboxClientServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('affilbox-client.instance_number', 'test-instance');
        config()->set('affilbox-client.api_key', 'test-api-key');
    }
}
