<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests;

use Tipoff\EscapeRoom\EscapeRoomServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\Scheduler\SchedulerServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            LocationsServiceProvider::class,
            EscapeRoomServiceProvider::class,
            SchedulerServiceProvider::class,
        ];
    }
}
