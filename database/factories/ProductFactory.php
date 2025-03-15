<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
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
        return [
            'uuid' => Str::uuid(),
            'name' => Str::ucfirst($this->faker->words(1, true))
                . ' '
                . $this->faker->randomElement(['Snack', 'Drink', 'Meal', 'Bar', 'Sauce', 'Bread', 'Juice']),
            'description' => $this->faker->sentence,
            'barcode' => $this->faker->unique()->ean13,
            'corporation_id' => null, // Will be set dynamically in tests
            'status' => 'published',
        ];
    }

    /**
     * Configure the factory to assign tags.
     *
     * @return Factory
     */
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->attachTags(['Organic', 'Non-GMO', 'Fair Trade', 'USDA Organic'], 'productCertification');
            $product->attachTags(['Recyclable Packaging', 'Plastic-Free', 'Compostable', 'Biodegradable'], 'productPackaging');
        });
    }
}
