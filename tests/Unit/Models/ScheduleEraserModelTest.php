<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\ScheduleEraser;
use Tipoff\Scheduler\Tests\TestCase;

class ScheduleEraserModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = ScheduleEraser::factory()->create();
        $this->assertNotNull($model);
    }
}
