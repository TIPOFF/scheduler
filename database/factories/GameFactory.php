<?php namespace Tipoff\Scheduling\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduling\Models\Game;
use Tipoff\Scheduling\Models\Slot;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startingDate = $this->faker->dateTimeBetween('-10 days', 'now');
        if ($this->faker->boolean) {
            // Escaped
            $time = $this->faker->numberBetween(1800, 7200);
            $clues = $this->faker->numberBetween(0, 7);
        } else {
            // No Data yet
            $time = null;
            $clues = null;
        }

        return [
            'slot_id'               => Slot::factory()->create(['start_at' => $startingDate]),
            'time'                  => $time,
            'clues'                 => $clues,
            'supervision_id'        => randomOrCreate(config('tipoff.model_class.supervision')),
            'monitor_id'            => randomOrCreate(config('tipoff.model_class.user')),
            'receptionist_id'       => randomOrCreate(config('tipoff.model_class.user')),
            'manager_id'            => randomOrCreate(config('tipoff.model_class.user')),
        ];
    }
}
