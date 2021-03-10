<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Tipoff\EscapeRoom\EscapeRoomServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\Scheduler\SchedulerServiceProvider;
use Tipoff\Scheduler\Tests\Support\Providers\NovaPackageServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;
use Tipoff\Addresses\AddressesServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            LocationsServiceProvider::class,
            EscapeRoomServiceProvider::class,
            SchedulerServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
            AddressesServiceProvider::class,
        ];
    }
}
