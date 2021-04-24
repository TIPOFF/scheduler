<?php

declare(strict_types=1);

namespace Tipoff\Scheduler\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Tipoff\Scheduler\Models\EscaperoomSlot;

class EscaperoomSlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EscaperoomSlot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $schedule = randomOrCreate(app('recurring_schedule'));

        $initialDate = $schedule->valid_from ?? Carbon::today();
        $startAt = $initialDate->addDays($this->faker->numberBetween(1, 30));
        while (!$schedule->matchDate($startAt)) {
            $startAt = $startAt->addDay();
        }

        $startAt = $startAt->setTime($this->faker->numberBetween(10,20), 0, 0);

        return [
            'room_id'            => randomOrCreate(app('room')),
            'slot_number'        => $this->faker->randomNumber,
            'schedule_type'      => 'recurring_schedules',
            'schedule_id'        => $schedule->id,
            'escaperoom_rate_id' => $this->faker->optional()->passthrough(randomOrCreate(app('escaperoom_rate'))),
            'supervision_id'     => randomOrCreate(app('supervision')),
            'start_at'           => $startAt,
            'end_at'             => $startAt->addMinutes(60),
        ];
    }
}
