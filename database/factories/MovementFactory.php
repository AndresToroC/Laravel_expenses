<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->text(),
            'value' => rand(50000, 1000000),
            'date' => $this->faker->dateTimeInInterval($startDate = '', $interval = '- 1 month', $timezone = null),
            'hour' => $this->faker->time($format = 'H:i:s', $max = 'now')
        ];
    }

    public function data($user_id, $sub_category_id) {
        return $this->state(function($attributes) use ($user_id, $sub_category_id) {
            return [
                'user_id' => $user_id,
                'sub_category_id' => Arr::random($sub_category_id)
            ];
        });
    }
}
