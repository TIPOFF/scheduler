<?php

declare(strict_types=1);

namespace Tipoff\Scheduling\Tests;

use Tipoff\Scheduling\SchedulingServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\EscapeRoom\EscapeRoomServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            LocationsServiceProvider::class,
            EscapeRoomServiceProvider::class,
            SchedulingServiceProvider::class,
        ];
    }
}
