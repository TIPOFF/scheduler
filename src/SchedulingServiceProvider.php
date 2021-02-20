<?php

declare(strict_types=1);

namespace Tipoff\Scheduling;

use Tipoff\Scheduling\Models\Block;
use Tipoff\Scheduling\Models\Game;
use Tipoff\Scheduling\Models\RecurringSchedule;
use Tipoff\Scheduling\Models\ScheduleEraser;
use Tipoff\Scheduling\Policies\BlockPolicy;
use Tipoff\Scheduling\Policies\GamePolicy;
use Tipoff\Scheduling\Policies\RecurringSchedulePolicy;
use Tipoff\Scheduling\Policies\ScheduleEraserPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SchedulingServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Block::class => BlockPolicy::class,
                Game::class => GamePolicy::class,
                RecurringSchedule::class => RecurringSchedulePolicy::class,
                ScheduleEraser::class => ScheduleEraserPolicy::class,
            ])
            ->name('scheduling')
            ->hasConfigFile();
    }
}
