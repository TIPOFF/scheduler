<?php namespace Tipoff\Scheduling\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduling\Models\Block;

class BlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Block::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slot_id'      => randomOrCreate(config('tipoff.model_class.slot')),
            'participants' => $this->faker->numberBetween(1, 10),
            'type'         => $this->faker->word,
            'creator_id'   => randomOrCreate(config('tipoff.model_class.user')),
        ];
    }
}
