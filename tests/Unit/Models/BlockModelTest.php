<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\Block;
use Tipoff\Scheduler\Models\EscaperoomSlot;
use Tipoff\Scheduler\Tests\TestCase;

class BlockModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Block::factory()->create();
        $this->assertNotNull($model);
        return $model;
    }

    /**
    @test
    *@depends create
    */
    public function it_has_participants(Block $model)
    {
        $this->assertIsInt($model->participants);
    }

    /**
    @test
    */
    public function it_has_a_slot()
    {
        $model = Block::factory()->create();
        $this->assertInstanceOf(EscaperoomSlot::class, $model->slot);
    }
}
