<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\Block;
use Tipoff\Scheduler\Tests\TestCase;

class BlockModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Block::factory()->create();
        $this->assertNotNull($model);
    }
}
