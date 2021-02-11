<?php

namespace Tipoff\Scheduling\Tests;

use Tipoff\Scheduling\SchedulingServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            SchedulingServiceProvider::class,
        ];
    }
}
