<?php namespace Tipoff\Scheduling\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduling\Models\RecurringSchedule;

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
            'room_id' => randomOrCreate(config('tipoff.model_class.room')),
            'rate_id' => randomOrCreate(config('tipoff.model_class.rate')),

            'day'  => rand(1, 7),
            'time' => rand(0, 24) . ':00:00',

            'valid_from' => now(),
            'expires_at' => now()->addMonths(6),
            'creator_id' => randomOrCreate(config('tipoff.model_class.user')),
            'updater_id' => randomOrCreate(config('tipoff.model_class.user')),
        ];
    }
}
