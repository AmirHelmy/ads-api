<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

class AdFactory extends Factory
{


    protected $model = Ad::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => fn () => Category::factory()->create()->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->text(),
            'start_date' => today()->addDays(rand(1, 10)),
            'type' => 'free',
        ];
    }

    /**
     * alternate the value of an type column between free and paid for each created Ad.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function typed()
    {
        return $this->state(new Sequence(
            ['type' => 'free'],
            ['type' => 'paid'],
        ));
    }
}
