<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduler\Models\RecurringSchedule;

class RecurringScheduleFactory extends Factory
{
    protected $model = RecurringSchedule::class;

    public function definition()
    {
        return [
            'room_id' => randomOrCreate(app('room')),
            'escaperoom_rate_id' => randomOrCreate(app('escaperoom_rate')),

            'day'  => $this->faker->numberBetween(1,7),
            'time' => $this->faker->numberBetween(0,23) . ':00:00',

            'valid_from' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonths(6),
            'creator_id' => randomOrCreate(app('user')),
            'updater_id' => randomOrCreate(app('user')),
        ];
    }
}
