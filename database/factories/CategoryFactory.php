<?php

namespace Database\Factories;

use App\Helpers\FormatHelper;
use App\Helpers\TranslationHelper;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
        $country = $this->faker->unique()->country;

        $slug = FormatHelper::slugify($country);


        return [
            'slug' => $slug,
            ...TranslationHelper::generateTranslations([
                ['title', 'country', ['unique'], $seed],
            ]),
        ];
    }
}
