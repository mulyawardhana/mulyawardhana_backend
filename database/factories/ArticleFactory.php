<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
                'user_id'  => 1,
                'title'    => $this->faker->name(),
                'desc'    => $this->faker->name(),

        ];
    }
}
