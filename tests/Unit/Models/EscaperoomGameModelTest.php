<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tipoff\Scheduler\Models\EscaperoomGame;
use Tipoff\Scheduler\Tests\TestCase;

class EscaperoomGameModelTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create()
    {
        $model = EscaperoomGame::factory()->create();
        $this->assertNotNull($model);
    }
}
