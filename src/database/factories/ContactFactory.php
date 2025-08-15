<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $categoryId = Category::inRandomOrder()->value('id');

        return [
            'category_id' => $categoryId,
            'name' => $this->faker->name(),
            'gender' =>  $this->faker->randomElement(['男性','女性','その他']),
            'email' =>  $this->faker->safeEmail(),
            'tel' => preg_replace('/\D+/', '', $this->faker->phoneNumber()),
            'address' => $this->faker->prefecture() . $this->faker->city() . $this->faker->streetAddress(),
            'building' => $this->faker->optional()->secondaryAddress(),
            'detail' => $this->faker->realText(120),
        ];
    }
}
