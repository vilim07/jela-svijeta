<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\FormatHelper;
use App\Helpers\TranslationHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
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
        $word = $this->faker->unique()->safeColorName;

        $slug = FormatHelper::slugify($word);


        return [
            'slug' => $slug,
            ...TranslationHelper::generateTranslations([
                ['title', 'safeColorName', ['unique'], $seed],
            ]),
        ];
    }
}
