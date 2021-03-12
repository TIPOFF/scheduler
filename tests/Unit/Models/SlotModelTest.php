<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\Slot;
use Tipoff\Scheduler\Tests\TestCase;

class SlotModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Slot::factory()->create();
        $this->assertNotNull($model);
    }
}
