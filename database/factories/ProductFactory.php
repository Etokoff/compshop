<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->realText(rand(40, 50));
        return [
            //
            'category_id' => rand(1, 25),
            'brand_id' => rand(1, 18),
            'name' => $name,
            'content' => $this->faker->realText(rand(400, 500)),
            'slug' => Str::slug($name),
            'price' => rand(100, 2000),
        ];
    }
}
