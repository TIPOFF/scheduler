<?php 

declare(strict_types=1);

namespace Tipoff\Scheduler\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduler\Models\RecurringSchedule;

class RecurringScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecurringSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id' => randomOrCreate(app('room')),
            'escaperoom_rate_id' => randomOrCreate(app('escaperoom_rate')),

            'day'  => rand(1, 7),
            'time' => rand(0, 24) . ':00:00',

            'valid_from' => now(),
            'expires_at' => now()->addMonths(6),
            'creator_id' => randomOrCreate(app('user')),
            'updater_id' => randomOrCreate(app('user')),
        ];
    }
}
