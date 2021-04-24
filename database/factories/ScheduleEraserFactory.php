<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduler\Models\ScheduleEraser;

class ScheduleEraserFactory extends Factory
{
    protected $model = ScheduleEraser::class;

    public function definition()
    {
        $days = $this->faker->numberBetween(1, 30);

        return [
            'start_at'   => Carbon::now()->addDays($days),
            'end_at'     => Carbon::now()->addDays($days + 1),
            'room_id'    => randomOrCreate(app('room')),
            'creator_id' => randomOrCreate(app('user')),
        ];
    }
}
