<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\RecurringSchedule;
use Tipoff\Scheduler\Tests\TestCase;

class RecurringScheduleModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = RecurringSchedule::factory()->create();
        $this->assertNotNull($model);
    }
}
