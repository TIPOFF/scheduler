<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Support\Providers;

use Tipoff\Scheduler\Nova\Block;
use Tipoff\Scheduler\Nova\EscaperoomSlot;
use Tipoff\Scheduler\Nova\Game;
use Tipoff\Scheduler\Nova\RecurringSchedule;
use Tipoff\Scheduler\Nova\ScheduleErarser;
use Tipoff\Scheduler\Nova\EscaperoomSlot;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Block::class,
        Game::class,
        RecurringSchedule::class,
        ScheduleErarser::class,
        EscaperoomSlot::class,
    ];
}
