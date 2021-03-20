<?php

declare(strict_types=1);

namespace Tipoff\Scheduler;

use Tipoff\Scheduler\Models\Block;
use Tipoff\Scheduler\Models\EscaperoomGame;
use Tipoff\Scheduler\Models\EscaperoomSlot;
use Tipoff\Scheduler\Models\RecurringSchedule;
use Tipoff\Scheduler\Models\ScheduleEraser;
use Tipoff\Scheduler\Policies\BlockPolicy;
use Tipoff\Scheduler\Policies\EscaperoomGamePolicy;
use Tipoff\Scheduler\Policies\EscaperoomSlotPolicy;
use Tipoff\Scheduler\Policies\RecurringSchedulePolicy;
use Tipoff\Scheduler\Policies\ScheduleEraserPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SchedulerServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Block::class => BlockPolicy::class,
                EscaperoomGame::class => EscaperoomGamePolicy::class,
                RecurringSchedule::class => RecurringSchedulePolicy::class,
                ScheduleEraser::class => ScheduleEraserPolicy::class,
                EscaperoomSlot::class => EscaperoomSlotPolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Scheduler\Nova\Block::class,
                \Tipoff\Scheduler\Nova\EscaperoomGame::class,
                \Tipoff\Scheduler\Nova\RecurringSchedule::class,
                \Tipoff\Scheduler\Nova\ScheduleEraser::class,
                \Tipoff\Scheduler\Nova\EscaperoomSlot::class,
            ])
            ->name('scheduler')
            ->hasConfigFile();
    }
}
