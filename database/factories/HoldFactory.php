<?php namespace Tipoff\Scheduling\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tipoff\Scheduling\Models\Hold;

class HoldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hold::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slot_id'        => randomOrCreate(config('tipoff.model_class.slot')),
            'creator_id'     => randomOrCreate(config('tipoff.model_class.user')),
        ];
    }
}
