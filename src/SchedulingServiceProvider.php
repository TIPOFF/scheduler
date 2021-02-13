<?php

declare(strict_types=1);

namespace Tipoff\Scheduling;

use Tipoff\Scheduling\Models\Block;
use Tipoff\Scheduling\Models\Game;
use Tipoff\Scheduling\Models\Hold;
use Tipoff\Scheduling\Models\RecurringSchedule;
use Tipoff\Scheduling\Models\ScheduleEraser;
use Tipoff\Scheduling\Models\Slot;
use Tipoff\Scheduling\Policies\SchedulingPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SchedulingServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Scheduling::class => SchedulingPolicy::class,
            ])
            ->name('scheduling')
            ->hasConfigFile();
    }
}
