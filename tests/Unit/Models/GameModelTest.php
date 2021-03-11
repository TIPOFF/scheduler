<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\Game;
use Tipoff\Scheduler\Tests\TestCase;

class GameModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = Game::factory()->create();
        $this->assertNotNull($model);
    }
}