<?php

namespace Tipoff\Scheduling;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tipoff\Scheduling\Scheduling
 */
class SchedulingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scheduling';
    }
}
