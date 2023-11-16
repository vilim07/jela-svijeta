<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\TranslationHelper;
use App\Helpers\FormatHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seed = mt_rand();
        $this->faker->seed($seed);
        $this->faker->addProvider(new \Bezhanov\Faker\Provider\Food($this->faker));

        $ingredient = $this->faker->unique()->ingredient;

        $slug = FormatHelper::slugify($ingredient);


        return [
            'slug' => $slug,
            ...TranslationHelper::generateTranslations([
                ['title', 'ingredient', ['unique'], $seed],
            ]),
        ];
    }
}
