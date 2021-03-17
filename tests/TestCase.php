<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Addresses\AddressesServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Bookings\BookingsServiceProvider;
use Tipoff\EscapeRoom\EscapeRoomServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\Scheduler\SchedulerServiceProvider;
use Tipoff\Scheduler\Tests\Support\Providers\NovaPackageServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\Statuses\StatusesServiceProvider;
use Tipoff\TestSupport\BaseTestCase;
use DrewRoberts\Media\MediaServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            AddressesServiceProvider::class,
            AuthorizationServiceProvider::class,
            LocationsServiceProvider::class,
            EscapeRoomServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
            SchedulerServiceProvider::class,
            BookingsServiceProvider::class,
            PermissionServiceProvider::class,
            StatusesServiceProvider::class,
            MediaServiceProvider::class,
        ];
    }
}
