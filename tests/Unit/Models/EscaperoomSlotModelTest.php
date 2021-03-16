<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\EscaperoomSlot;
use Tipoff\Scheduler\Tests\TestCase;

class EscaperoomSlotModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = EscaperoomSlot::factory()->create();
        $this->assertNotNull($model);
    }
}
