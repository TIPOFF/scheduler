<?php 

declare(strict_types=1);

namespace Tipoff\Scheduler\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduler\Models\EscaperoomGame;
use Tipoff\Scheduler\Models\EscaperoomSlot;
use Carbon\Carbon;

class EscaperoomGameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EscaperoomGame::class;

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
            'escaperoom_slot_id'               => EscaperoomSlot::factory()->create(['start_at' => $startingDate]),
            'time'                  => $time,
            'clues'                 => $clues,
            'date'                  => Carbon::now(),
            'room_id'               => randomOrCreate(app('room')),
            'supervision_id'        => randomOrCreate(app('supervision')),
            'monitor_id'            => randomOrCreate(app('user')),
            'receptionist_id'       => randomOrCreate(app('user')),
            'receptionist_id'       => randomOrCreate(app('user')),
            'manager_id'            => randomOrCreate(app('user')),
        ];
    }
}
