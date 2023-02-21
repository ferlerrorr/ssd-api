<?php

namespace Database\Factories;
use App\Models\Products;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'generic_name' => $this->faker->word,
            'grams' => $this->faker->numberBetween($min = 10, $max = 100), // 98,
            'product_name' => $this->faker->word,
            'category' => $this->faker->word,
            'variant_id' => $this->faker->creditCardNumber,          
            'level' => $this->faker->randomDigit, // 98,
        ];
    }
}
