<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Corporation;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Corporation>
 */
class CorporationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Corporation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
        ];
    }

    /**
     * Configure the factory to assign tags.
     *
     * @return Factory
     */
    public function configure()
    {
        return $this->afterCreating(function (Corporation $corporation) {
            $corporation->attachTags(['B Corporation', '1% for the Planet'], 'corporationEthicalLabel');
        });
    }
}
