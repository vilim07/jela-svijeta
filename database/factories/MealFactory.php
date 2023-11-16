<?php

namespace Database\Factories;

use App\Helpers\TranslationHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Meal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Meal::class;

    public function definition(): array
    {
        $updated = null;

        if (mt_rand(0,1) == 1) {
            $updated = $this->faker->dateTimeThisYear('+2 months');
        }

        //setting updated_at to null because the seeding process will set it to now otherwise
        return [
            ...TranslationHelper::generateTranslations([
                ['title', 'foodName', ['unique'], true],
                ['description', 'paragraph', []],
            ]),
            'updated_at' => $updated,

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Meal $meal) {
            // Disable timestamps
            $meal->timestamps = false;
        });
    }

}
