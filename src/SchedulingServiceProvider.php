<?php

declare(strict_types=1);

namespace Tipoff\Scheduling;

use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class SchedulingServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('scheduling')
            ->hasConfigFile();
    }
}
